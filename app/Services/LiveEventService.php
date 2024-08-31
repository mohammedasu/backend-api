<?php

namespace App\Services;

use App\Constants\ChatConstants;
use App\Constants\LiveEventConstants;
use App\Exceptions\CustomErrorException;
use App\Helpers\CommonHelper;
use App\Helpers\CommunityHelper;
use App\Helpers\ImageHelper;
use App\Jobs\GenerateCertificatesJob;
use Illuminate\Support\Facades\Log;
use App\Repositories\LiveEventRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LiveEventService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new LiveEventRepository();
        $this->chat_group_service = new ChatGroupService();
        $this->content_subscription_service = new ContentSubscriptionService();
        $this->feedback_survey_service = new FeedbackSurveyService();
        $this->live_event_member_service = new LiveEventMemberService();
    }

    public function getAll($request)
    {
        Log::info('LiveEventService | getAll', $request->all());
        try {
            return $this->repository->getAll($request);
        } catch (\Exception $e) {
            throw new CustomErrorException($e);
        }
    }

    public function store($request) {
        Log::info('LiveEventService | store ', $request->all());
        try {
            DB::beginTransaction();
            
            $params = $this->createRequest($request);
            if ($request->has('moderator_password') && $request->filled('moderator_password')) {
                $params['moderator_password'] = Hash::make($request->moderator_password);
            } 
            // $params['moderator_password'] = $request->moderator_password != null ? Hash::make($request->moderator_password) : null;
            if(!empty($request->quiz_id)) {
                $params['quiz_id'] = $request->quiz_id;
            }

            if ($request->hasFile('banner_image')) {
                $fileName = ImageHelper::storeImage($request->file('banner_image'), 'live_event_banner_image', 'banner_image', true, 's3');
                $params['banner_image'] = $fileName;
            }
            if ($request->hasFile('mobile_banner_image')) {
                $fileName = ImageHelper::storeImage($request->file('mobile_banner_image'), 'live_event_banner_image', 'mobile_banner_image', true, 's3');
                $params['mobile_banner_image'] = $fileName;
            }
            if ($request->hasFile('register_image1')) {
                $fileName = ImageHelper::storeImage($request->file('register_image1'), 'live_event_banner_image', 'register_image1', true, 's3');
                $params['register_image1'] = $fileName;
            }
            if ($request->hasFile('register_image2')) {
                $fileName = ImageHelper::storeImage($request->file('register_image2'), 'live_event_banner_image', 'register_image2', true, 's3');
                $params['register_image2'] = $fileName;
            }
            if ($request->hasFile('thumbnail_image')) {
                $fileName = ImageHelper::storeImage($request->file('thumbnail_image'), 'live_event_thumbnail_image', 'thumbnail_image', true, 's3');
                $params['thumbnail_image'] = $fileName;
            }

            if ($request->has('banner_vimeo_video_id') && ($request->banner_vimeo_video_id != '')) {
                $params['banner_vimeo_video_id'] = $request->banner_vimeo_video_id;
            }

            if ($request->hasFile('register_success_image')) {
                $fileName = ImageHelper::storeImage($request->file('register_success_image'), 'live_event_banner_image', 'register_success_image', true, 's3');
                $params['register_success_image'] = $fileName;
            }
            if ($request->hasFile('event_completed_image')) {
                $fileName = ImageHelper::storeImage($request->file('event_completed_image'), 'live_event_banner_image', 'event_completed_image', true, 's3');
                $params['event_completed_image'] = $fileName;
            }

            $chat_params = ['group_name' => $params['link_id'], 'chat_type' => ChatConstants::LIVE_EVENT];
            $group = $this->chat_group_service->store($chat_params);
            $params['live_event_chat_group'] = $group->id;
            if ($request->has('password') && $request->filled('password')) {
                $params['password'] = encrypt($request->password);
                $params['password_placeholder'] = $request->password_placeholder;
            }
            if ($params['is_non_vimeo_event'] == LiveEventConstants::VIDEO_CRYPT) {
                $videoCrypt = new VideoService();
                $videocrypt_response = $videoCrypt->getVideoCryptUrl($params['video_link']);
                $params['aws_response'] = json_encode($videocrypt_response);
            }

            if ($request->type == 'tabs') {
                $params['registration_tabs'] = $request->registration_tabs;
            } else if ($request->type == 'communities') {
                $params['community_for_registration'] = $request->communities;
            }

            $params['has_certificates'] = !empty($request->has_certificates) ? true : false;
            $params['rewards'] = (float)$request->rewards;
            if ($request->has('certificate_id') && ($request->certificate_id != '')) {
                $params['certificate_id'] = $request->certificate_id;
            }

            $live_event = $this->repository->create($params);
            if($params['is_payed_event']) {
                $payment_params = ['content_type' => $request->content_type, 'content_id' => $live_event->id, 'amount' => $request->amount, 'currency' => $request->currency];
                $this->content_subscription_service->store($payment_params);
            }

            if(!empty($request->survey_type)) {  
                $feedback_survey = json_decode($request->feedback_survey, true);
                foreach($feedback_survey as $val) {
                    if(!empty($val['question'])){
                        $option = [];
                        if($val['feedback_type'] == 'option_rating'){
                            $option = $val['option'];
                        }
                        
                        $survey_params = ['is_active' => $val['is_active'], 'link_id' => $live_event->id, 'question' => $val['question'], 'feedback_type' => $val['feedback_type'], 'option' => $option, 'survey_type' => $request['survey_type']];
                        $this->feedback_survey_service->store($survey_params);
                    }
                }
            }
            
            CommonHelper::storeExpertMap($request->experts, $live_event->id, 'live_event');
            CommonHelper::storeSubSpecialities($request->sub_specialities, $live_event->id, 'live_event', false);
            
            DB::commit();
            return $live_event;
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e);
            throw new CustomErrorException($e, 'Something went wrong with storing live event');
        }
    }

    public function update($request) {
        Log::info('LiveEventService | update ', $request->all());
        try {
            DB::beginTransaction();
            $params = $this->createRequest($request);
            if ($request->has('moderator_password') && $request->filled('moderator_password')) {
                $params['moderator_password'] = Hash::make($request->moderator_password);
            } 
            // $params['moderator_password'] = $request->moderator_password != null ? Hash::make($request->moderator_password) : (!empty($request->same_moderator_password) ? $request->same_moderator_password : null);
            if(!empty($request->quiz_id)) {
                $params['quiz_id'] = $request->quiz_id;
            }

            $fetch = $this->show($request->id);

            if ($request->hasFile('banner_image')) {
                if(!empty($fetch) && !empty($fetch->banner_image)) {
                    ImageHelper::destroyImage($fetch->banner_image, 'live_event_banner_image', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('banner_image'), 'live_event_banner_image', 'banner_image', true, 's3');
                $params['banner_image'] = $fileName;
            }
            if ($request->hasFile('mobile_banner_image')) {
                if(!empty($fetch) && !empty($fetch->mobile_banner_image)) {
                    ImageHelper::destroyImage($fetch->mobile_banner_image, 'live_event_banner_image', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('mobile_banner_image'), 'live_event_banner_image', 'mobile_banner_image', true, 's3');
                $params['mobile_banner_image'] = $fileName;
            }
            if ($request->hasFile('register_image1')) {
                if(!empty($fetch) && !empty($fetch->register_image1)) {
                    ImageHelper::destroyImage($fetch->register_image1, 'live_event_banner_image', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('register_image1'), 'live_event_banner_image', 'register_image1', true, 's3');
                $params['register_image1'] = $fileName;
            }
            if ($request->hasFile('register_image2')) {
                if(!empty($fetch) && !empty($fetch->register_image2)) {
                    ImageHelper::destroyImage($fetch->register_image2, 'live_event_banner_image', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('register_image2'), 'live_event_banner_image', 'register_image2', true, 's3');
                $params['register_image2'] = $fileName;
            }
            if ($request->hasFile('thumbnail_image')) {
                if(!empty($fetch) && !empty($fetch->thumbnail_image)) {
                    ImageHelper::destroyImage($fetch->thumbnail_image, 'live_event_thumbnail_image', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('thumbnail_image'), 'live_event_thumbnail_image', 'thumbnail_image', true, 's3');
                $params['thumbnail_image'] = $fileName;
            }

            if ($request->has('banner_vimeo_video_id') && ($request->banner_vimeo_video_id != '')) {
                $params['banner_vimeo_video_id'] = $request->banner_vimeo_video_id;
            }

            if ($request->hasFile('register_success_image')) {
                if(!empty($fetch) && !empty($fetch->register_success_image)) {
                    ImageHelper::destroyImage($fetch->register_success_image, 'live_event_banner_image', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('register_success_image'), 'live_event_banner_image', 'register_success_image', true, 's3');
                $params['register_success_image'] = $fileName;
            }
            if ($request->hasFile('event_completed_image')) {
                if(!empty($fetch) && !empty($fetch->event_completed_image)) {
                    ImageHelper::destroyImage($fetch->event_completed_image, 'live_event_banner_image', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('event_completed_image'), 'live_event_banner_image', 'event_completed_image', true, 's3');
                $params['event_completed_image'] = $fileName;
            }

            $chat_params = ['group_name' => $params['link_id'], 'chat_type' => ChatConstants::LIVE_EVENT];
            $group = $this->chat_group_service->updateOrCreate($chat_params);
            $params['live_event_chat_group'] = $group->id;
            if ($request->has('password') && $request->filled('password')) {
                $params['password'] = encrypt($request->password);
                $params['password_placeholder'] = $request->password_placeholder;
            } 
            // else {
            //     $params['password'] = !empty($request->same_password) ? $request->same_password : null;
            //     $params['password_placeholder'] = $request->password_placeholder;
            // }
            if ($params['is_non_vimeo_event'] == LiveEventConstants::VIDEO_CRYPT) {
                $videoCrypt = new VideoService();
                $videocrypt_response = $videoCrypt->getVideoCryptUrl($params['video_link']);
                $params['aws_response'] = json_encode($videocrypt_response);
            }

            unset($params['upcoming_webinar_msg_sent']);
            // unset($params['registration_tabs']);
            if ($request->type == 'tabs') {
                $params['registration_tabs'] = $request->registration_tabs;
            } else if ($request->type == 'communities') {
                $params['community_for_registration'] = $request->communities;
            }
            $params['has_certificates'] = !empty($request->has_certificates) ? true : false;
            $params['rewards'] = (float)$request->rewards;
            if ($request->has('certificate_id') && ($request->certificate_id != '')) {
                $params['certificate_id'] = $request->certificate_id;
            }
            $where = ['id' => $request->id];
            $live_event = $this->repository->update($where, $params);

            if($params['is_payed_event']) {
                $payment_params = ['content_type' => $request->content_type, 'content_id' => $live_event->id, 'amount' => $request->amount, 'currency' => $request->currency];
                $this->content_subscription_service->store($payment_params);
            } else {
                $payment_where = ['content_type' => $request->content_type, 'content_id' => $live_event->id];
                $this->content_subscription_service->destroy($payment_where);
            }

            if(!empty($request->survey_type)) {
                $id = [];
                $feedback_survey = json_decode($request->feedback_survey, true);
                foreach($feedback_survey as $val) {
                    if(!empty($val['question'])){
                        $option = [];
                        if($val['feedback_type'] == 'option_rating'){
                            $option = $val['option'];
                        }
                        
                        $survey_params = ['is_active' => $val['is_active'], 'id' => $val['id'], 'link_id' => $live_event->id, 'question' => $val['question'], 'feedback_type' => $val['feedback_type'], 'option' => $option, 'survey_type' => $request['survey_type']];
                        $data = $this->feedback_survey_service->update($survey_params);
                        array_push($id, $data->id);
                    }
                }
                if(!empty($id)) {
                    $this->feedback_survey_service->destroyMultiple($id, $live_event->id);
                }
            } else {
                $survey_where = ['link_id' => $live_event->id];
                $this->feedback_survey_service->destroy($survey_where);
            }

            CommonHelper::storeExpertMap($request->experts, $live_event->id, 'live_event');
            CommonHelper::storeSubSpecialities($request->sub_specialities, $live_event->id, 'live_event', true);

            DB::commit();

            return $live_event;
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e);
            throw new CustomErrorException($e, 'Something went wrong with storing live event');
        }
    }

    public function getMemberLiveEventRewards($member)
    {
        Log::info('LiveEventService | getAll', ['member' => $member]);
        try {
            return $this->repository->getMemberLiveEventRewards($member);
        } catch (\Exception $e) {
            throw new CustomErrorException($e);
        }
    }

    /**
     * Function to fetch LiveEvent
     */

    public function fetch($request)
    {
       Log::info('LiveEventService | show', $request->all());
        $data = $this->repository->fetch(['link_id' => $request->link_id]);
        if (!$data) {
            throw new CustomErrorException(null, 'Something Went Wrong in Fetching LiveEvent.', 500);
        }
        return $data;
    }

    /**
     * Function to show LiveEvent
     */

    public function show($id)
    {
       Log::info('LiveEventService | show', ['id' => $id]);
        $data = $this->repository->fetch(['id' => $id]);
        if (!$data) {
            throw new CustomErrorException(null, 'Something Went Wrong in Fetching LiveEvent.', 500);
        }
        return $data;
    }

    public function updateStatus($request) {
        Log::info('LiveEventService | updateStatus ', $request->all());
        
        $where = ['id' => $request->id];
        if(isset($request->active_chat)) {
            $params = ['active_chat' => $request->active_chat, 'ip_address' => $request->ip()];
        } else if(isset($request->private_chat)) {
            $params = ['private_chat' => $request->private_chat, 'ip_address' => $request->ip()];
        } else {
            $params = ['is_active' => $request->is_active, 'ip_address' => $request->ip()];
        }
        Log::info($params);
        return $this->repository->update($where, $params);
    }

    public function destroy($request) {
        Log::info('LiveEventService | destroy ', $request->all());

        $where = ['id' => $request->id];
        $request['is_active'] = 0;
        $this->updateStatus($request);
        return $this->repository->destroy($where);
    }

    public function generateCertificate($request) {
        Log::info('LiveEventService | generateCertificate ', $request->all());
        
        $where = ['id' => $request->id];
        $params = ['certificate_generated_time' => Carbon::now()->toDateTimeString()];
        $data = $this->repository->update($where, $params);
        dispatch(new GenerateCertificatesJob($data->id));
        if (!$data) {
            throw new CustomErrorException(null, 'Please Try After 15-20 Min ,Certificates Already Generated.', 500);
        }
        return $data;
    }

    public function liveEventDownload($request) {
        Log::info('LiveEventService | liveEventDownload ', $request->all());

        $where = ['id' => $request->id];
        $live_event = $this->repository->fetch($where);
        if(!empty($live_event)) {
            $live_event_members = $this->live_event_member_service->download($request, $live_event);

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=' . $live_event_members['file_name']);
            $output = fopen('php://output', 'w');
            ob_end_clean();

           fputcsv($output, $live_event_members['column_array']);

            if ($live_event_members['live_event_members'] > 0) {
                foreach ($live_event_members['live_event_members'] as $live_event_member) {
                    fputcsv($output, (array)$live_event_member);
                }
            }

            $fileName = ImageHelper::storeImage($output, 'live_event_csv', 'live_event_csv', true, 's3',$live_event_members['file_name']);

            return $fileName;
        }
    }

    public function sendMail($request) {
        Log::info('LiveEventService | sendMail ', $request->all());

        $where = ['id' => $request->id];
        $params = ['sent_success_email' => 1, 'ip_address' => $request->ip()];
        $live_event = $this->repository->update($where, $params);

        $live_member_where = ['link_id' => $live_event->id, 'visited_during_session' => 1];
        return $this->live_event_member_service->fetchMembers($live_member_where, $live_event);
    }

    public function createRequest($request) {
        $session_month = Carbon::parse($request->session_time)->format('m');
        
        return [
            'link_id' => $request->link_id,
            'session_time' => $request->session_time,
            'buffer_time' => $request->buffer_time,
            'title' => $request->title,
            'partner_id' => $request->partner_id,
            'email_link' => $request->email_link,
            'time_zone' => $request->time_zone,
            'time_zone_code' => $request->time_zone_code,
            'calender_description' => $request->calender_description,
            'video_id' => $request->video_id,
            'vchat_id' => $request->vchat_id,
            'chat_type' => $request->chat_type == 0 ? ChatConstants::VIMEO_CHAT_TYPE : ($request->chat_type == 2 ? ChatConstants::JIVO_CHAT : ChatConstants::MEDISAGE_CHAT),
            'live_event_text' => $request->live_event_text,
            'description' => $request->description,
            'tnc_detail' => $request->tnc_detail,
            'partner_division_id' => $request->partner_division_id,
            'community_id' => $request->community_id,
            'knowledge_category_id' => $request->knowledge_category_id,
            'video_link' => $request->video_link,
            'is_non_vimeo_event' => ($request->video_event_type == '0') ? LiveEventConstants::VIMEO_EVENT : ($request->video_event_type == '1' ? LiveEventConstants::YOUTUBE_EVENT : ($request->video_event_type == '2' ? LiveEventConstants::DACAST_EVENT : LiveEventConstants::VIDEO_CRYPT)),
            'is_payed_event' => $request->is_payed_event == '1',
            'upcoming_webinar_msg_sent' => false,
            'non_medical_event' => ($request->non_medical_event == '1') ? 1 : 0,
            'is_survey_event' => ($request->is_survey_event == '1') ? 1 : 0,
            'subsequent_survey' => ($request->subsequent_survey == '1') ? 1 : 0,
            'show_in_home' => ($request->show_in_home == '1') ? 1 : 0,
            'show_header_footer' => ($request->show_header_footer == '1') ? 1 : 0,
            'send_sms' => ($request->send_sms == '1') ? 1 : 0,
            'send_whatsapp' => ($request->send_whatsapp == '1') ? 1 : 0,
            'send_email' => ($request->send_email == '1') ? 1 : 0,
            'show_in_app' => ($request->show_in_app == '1') ? 1 : 0,
            'show_hospital_name' => ($request->show_hospital_name == '1') ? 1 : 0,
            'event_month' => $session_month,
            'ip_address' => $request->ip(),
            'session_end_time' => $request->session_end_time,
            'external_event' => $request->external_event,
            'redirect_away_without_registration' => $request->redirect_away_without_registration,
            'subsequent_survey' => ($request->subsequent_survey == '1') ? 1 : 0,
            'is_user_type' => ($request->is_user_type == '1') ? 1 : 0,
            'is_speciality' => ($request->is_speciality == '1') ? 1 : 0,
            'user_types' => !empty($request->user_types) ? json_encode($request->user_types) : null,
            'live_event_country' => !empty($request->live_event_country) ? ('+' . $request->live_event_country) : '+91',
            'is_mmc_number' => ($request->is_mmc_number == '1') ? 1 : 0,
            'is_open_event' => !empty($request->is_open_event) ? 1 : 0,
            'hide_video' => !empty($request->hide_video) ? 1 : 0,
            // 'registration_tabs' => "{\"city\": {\"label\": \"City\", \"active\": \"on\", \"required\": \"on\", \"placeholder\": \"City\"}, \"email\": {\"label\": \"Email\", \"active\": \"on\", \"required\": \"on\", \"placeholder\": \"Email\"}, \"state\": {\"label\": \"State\", \"active\": \"on\", \"required\": \"on\", \"placeholder\": \"State\"}, \"company\": {\"label\": \"Company name\", \"placeholder\": \"Company name\"}, \"community\": {\"label\": \"Community\", \"placeholder\": \"Community\"}, \"last_name\": {\"label\": \"Last name\", \"active\": \"on\", \"required\": \"on\", \"placeholder\": \"Last name\"}, \"first_name\": {\"label\": \"First name\", \"active\": \"on\", \"required\": \"on\", \"placeholder\": \"First name\"}, \"hospital_name\": {\"label\": \"Hospital name\", \"placeholder\": \"Hospital name\"}, \"mobile_number\": {\"label\": \"Phone number\", \"active\": \"on\", \"required\": \"on\", \"placeholder\": \"Phone number\"}, \"registration_id\": {\"label\": \"Registration id\", \"placeholder\": \"Registration id\"}, \"registration_number\": {\"label\": \"Registration number\", \"placeholder\": \"Registration number\"}}",

        ];
    }
}

