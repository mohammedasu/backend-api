<?php

namespace App\Services;

use Carbon\Carbon;
use App\Helpers\ImageHelper;
use App\Traits\WhatsappTrait;
use App\Exceptions\CustomErrorException;
use App\Helpers\UtilityHelper;
use App\Helpers\UtmLinkHelper;
use App\Imports\WhatsappValidationImport;
use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    use WhatsappTrait;

    protected $repository;

    public function __construct()
    {
        $this->repository               = new NotificationRepository();
        $this->memberService            = new MemberService();
        $this->endPointService          = new EndPointService();
        $this->whatsappLogService       = new WhatsappLogService();
        $this->whatsappTemplateService  = new WhatsappTemplateService();
        $this->memberNotificatioService = new MemberNotificationService();
    }

    /**
     * Function to fetch all notification detail list
     */

    public function getAll($request)
    {
        Log::info('NotificationService | getAll', $request->all());
        try {
            return $this->repository->getAll($request);
        } catch (\Exception $e) {
            throw new CustomErrorException($e);
        }
    }

    /**
     * Function to check notification details
     */

    public function checkContent($request)
    {
        Log::info('NotificationService | checkContent', $request->all());
        try {
            $imageUrl = null;
            $fileName = null;
            $templateData = [];

            if ($request->send_to_medium == 'csv' && $request->hasFile('csv_file')) {
                $column = (new WhatsappValidationImport)->toArray(request()->file('csv_file'));
                $firstrow = $column[0][0];
                if ($firstrow[0] != 'id' || $firstrow[1] != 'country_code' || $firstrow[2] != 'fname' || $firstrow[3] != 'mobile_number' || $firstrow[4] != 'member_ref_no') {
                    throw new CustomErrorException(null, "Invalid CSV file", 500);
                }
            }

            if ($request->notification_type == 'whatsapp') {
                if ($request->action_type == 'custom' && $request->file('image') != null) {
                    $fileName = ImageHelper::storeImage($request->file('image'), 'notification', null, true, 's3');
                    $imageUrl = config('constants.notification_path') . $fileName;
                }
                $templateData = $this->whatsappTemplateService->getTemplatesForWhatsApp($request, $imageUrl);
                if ($templateData && $templateData['template']) {
                    $templateData['image_name'] = $fileName;
                    return $templateData;
                }
                throw new CustomErrorException(null, "Template Not Found.", 500);
            } elseif ($request->notification_type == 'app_notification') {
                $templateData = $this->whatsappTemplateService->getTemplatesForAppNotification($request);
                if ($templateData && $templateData['notification_title']) {
                    return $templateData;
                }
                throw new CustomErrorException(null, "something went wrong.", 500);
            }
        } catch (\Exception $e) {
            throw new CustomErrorException($e);
        }
    }

    /**
     * Function to store notification details
     */
    public function store($request)
    {
        Log::info('NotificationService | Store', $request->all());
        try {
            if ($request->notification_type == 'app_notification' && $request->send_to_medium != 'test' && $request->device_type == null) {
                throw new CustomErrorException(null, "Device type required when notification type selected as app notification.", 500);
            }

            $templateData = $this->checkContent($request);
            $members = null;

            if ($request->send_to_medium == 'test') {
                $params['mobile_numbers'] = explode(",", $request->mobile_numbers);
                $members = $this->memberService->getByParams($params);
                $members = $members->unique('mobile_number');
                if ($members->count() == 0) {
                    throw new CustomErrorException(null, "Members Not Found.", 500);
                }
                // $request->mergeIfMissing(['is_processed' => true]);
                // if (isset($templateData['image_name'])) {
                //     $request->mergeIfMissing(['image_name' => $templateData['image_name']]);
                // }
                // $engagement = $this->repository->store($this->CreateRequest($request, $members->count()));
                // $templateData['engagementId'] = $engagement->id;
                if ($request->notification_type == 'whatsapp') {
                    $this->sendWhatsappByMembers($members, $templateData);
                }
                if ($request->notification_type == 'app_notification') {
                    $memberData = $this->getMembersWithDeviceType($members);
                    $this->sendAppNotificationByMembers($memberData, $templateData);
                }
                $engagement = null;
            } elseif ($request->send_to_medium == 'csv' && $request->hasFile('csv_file')) {
                $fileName = ImageHelper::storeImage($request->file('csv_file'), 'notification', null, true, 's3');
                $request->mergeIfMissing(['file_name' => $fileName, 'is_processed' => false]);
                $engagement = $this->repository->store($this->CreateRequest($request));
            } else {
                $request->mergeIfMissing([
                    'data_filter_id' => $request->data_filter_id ? $request->data_filter_id : null,
                    'is_processed' => false
                ]);
                $engagement = $this->repository->store($this->CreateRequest($request));
            }
            return $engagement;
        } catch (\Exception $e) {
            throw new CustomErrorException($e);
        }
    }

    /**
     * Function to update notification details
     */
    public function update($request, $notification)
    {
        Log::info('NotificationService | update', $request->all());
        try {
            if ($notification->is_processed) {
                throw new CustomErrorException(null, "This notification request already been processed. You can't update it.", 500);
            }
            $templateData = $this->checkContent($request);

            $request->mergeIfMissing(['is_processed' => false, 'file_name' => $notification->import_csv]);


            if ($request->hasFile('image') && $request->file('image') != null && $notification->image != null) {
                ImageHelper::destroyImage($notification->image, 'notification', 's3');
                $request->mergeIfMissing(['image_name' => $templateData['image_name']]);
            }

            if ($request->send_to_medium == 'csv' && $request->hasFile('csv_file') && $request->file('csv_file') != null) {
                $fileName = ImageHelper::storeImage($request->file('csv_file'), 'notification', null, true, 's3');
                if ($notification->import_csv != null) {
                    ImageHelper::destroyImage($notification->import_csv, 'notification', 's3');
                }
                $request->merge(['file_name' => $fileName]);
            } else {
                if ($notification->import_csv != null) {
                    ImageHelper::destroyImage($notification->import_csv, 'notification', 's3');
                    $request->merge(['file_name' => null]);
                }
                $request->mergeIfMissing(['data_filter_id' => $request->data_filter_id ? $request->data_filter_id : null]);
            }
            return $this->repository->update($this->CreateRequest($request), $notification);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    /**
     * Function to create request data for notification details
     */

    public function CreateRequest($request, $recipentCount = 0)
    {
        return [
            'notification_type'     => $request->notification_type,
            'action_type'           => $request->action_type ?? null,
            'action_id'             => $request->action_id ?? null,
            'device_type'           => $request->device_type ?? null,
            'count'                 => $recipentCount,
            'is_processed'          => $request->is_processed ?? 1,
            'scheduled_timestamp'   => $request->scheduled_time ?? Carbon::now(),
            'payload'               => $request->toArray(),
            'target_members'        => ["members"],
            'engagement_name'       => $request->engagement_name ?? null,
            'import_csv'            => $request->file_name ?? null,
            'data_filter_id'        => $request->data_filter_id ?? null,
            'image'                 => $request->image_name ?? null,
            'created_from'          => 'admin',
            'created_by'            => auth('api')->user()->id
        ];
    }

    /**
     * Function to delete notification details
     */
    public function destroy($notification)
    {
        Log::info('NotificationService | delete');
        try {
            if ($notification->is_processed) {
                throw new CustomErrorException(null, "This notification request already been processed. You can't delete it.", 500);
            }
            if ($notification->type == 'csv' and $notification->csv_file) {
                ImageHelper::destroyImage($notification->csv_file, 'notification', 's3');
            }
            if ($notification->image != null) {
                ImageHelper::destroyImage($notification->image, 'notification', 's3');
            }
            $this->repository->destroy($notification);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    public function sendWhatsappByMembers($members, $templateData)
    {
        try {
            foreach ($members as $mem) {
                if (!isset($mem->mobile_number)) {
                    $object = new \stdClass();
                    foreach ($mem as $key => $value) {
                        $object->$key = $value;
                    }
                    $member = $object;
                } else {
                    $member = $mem;
                }

                $country_code = isset($member->country_code) ? $member->country_code : $member['country_code'];
                $whatsapp_number = isset($member->mobile_number) ? $member->mobile_number : $member['mobile_number'];
                $member_ref_no = isset($member->member_ref_no) ? $member->member_ref_no : $member['member_ref_no'];

                $mobile_number = str_replace('+', '', $country_code) . $whatsapp_number;

                $name = isset($member->name) ? $member->name : null;
                if (!$name) {
                    $name = isset($member->fname) ? $member->fname : $member->first_name;
                }

                if (isset($templateData['action_type']) && ($templateData['action_type'] == 'video' || $templateData['action_type'] == 'case' || $templateData['action_type'] == 'newsletter' || $templateData['action_type'] == 'newsarticle')) {
                    $linkDetails = [
                        "utm_medium"    => "whatsapp",
                        "doctor_id"     => $member_ref_no,
                        "universal_doctor_id" => $member_ref_no,
                        "project_id"    => null,
                        "digimr_id"     => null,
                    ];
                    $linkDetails["url"]          = $templateData['urlLink'];
                    $linkDetails["utm_id"]       = $templateData['action_id'];
                    $linkDetails["content_type"] = $templateData['action_type'];
                    // $linkDetails["utm_campaign"] = $templateData['engagementId'];
                    $linkDetails["utm_campaign"] = 0;

                    Log::info(['Link details data' => $linkDetails]);
                    $redirectedUrl = UtmLinkHelper::utmLinkGenerate($linkDetails);

                    $templateData['contentParams']->{2} = ' click on this link to view on website ' . ($redirectedUrl);
                }
                $templateData['contentParams']->{0} = $name;
                $data['contentParams']  = $templateData['contentParams'];
                $data['templateId']     = $templateData['template']->template_id;
                $data['mobileNumber']   = '+' . $mobile_number;
                $data['imageLink']      = $templateData['image'] ?? null;
                // $engagementId           = $templateData['engagementId'] ?? null;
                // $whatsappLog = $this->whatsappLogService->store([
                //     'type'                  => $data['templateId'],
                //     'whatsapp_template_id'  => $templateData['template']->id,
                //     'reference_type'        => 'member',
                //     'reference_id'          => $member_ref_no,
                //     'engagement_id'         => $engagementId,
                // ]);
                $responseBody = $this->sendWhatsappMessage($data); // need to add image link 
                // $responseBody['whatsappNumber'] = $whatsapp_number;
                // $this->whatsappLogService->update($responseBody, $whatsappLog->id);
            }
            return true;
        } catch (\Exception $e) {
            throw new CustomErrorException($e);
        }
    }

    public function getMembersWithDeviceType($members)
    {
        $androidMembers = $members->filter(function ($item) {
            return $item->device_type == 'android';
        })->values();
        $iosMembers = $members->filter(function ($item) {
            return $item->device_type == 'ios';
        })->values();

        return [
            'androidMembers'        => $androidMembers,
            'androidMemberTokens'   => $androidMembers->pluck('device_token')->toArray(),
            'androidMemberIds'      => $androidMembers->pluck('id')->toArray(),
            'iosMembers'            => $iosMembers,
            'iosMemberTokens'       => $iosMembers->pluck('device_token')->toArray(),
            'iosMemberIds'          => $iosMembers->pluck('id')->toArray()
        ];
    }

    public function sendAppNotificationByMembers($memberData, $templateData)
    {
        $response = null;
        if (!empty($memberData['androidMemberTokens'])) {
            // if (!empty($memberData['androidMemberIds']) && isset($templateData['engagementId'])) {
            // $this->createMemberNotifications($memberData['androidMemberIds'], $templateData['engagementId']);
            // }
            $device_token = $memberData['androidMemberTokens'];
            $chunks = array_chunk($device_token, 1000);
            foreach ($chunks as $chunk) {
                $param = [
                    'title'             => $templateData['notification_title'],
                    'message'           => $templateData['notification_description'],
                    'device_token'      => $chunk,
                    'auth_key'          => env("FCM_ANDROID_KEY"),
                    'action_type'       => $templateData['action_type'],
                    'action_id'         => $templateData['action_id'],
                    'device_type'       => 'android',
                    // 'notification_id'   => $templateData['engagementId']
                    'notification_id'   => 0
                ];
                $resp = $this->sendFCM($param);
                Log::info(['Response for android notification' => $resp]);
                $response = $response . $resp;
            }
        }

        if (!empty($memberData['iosMemberTokens'])) {
            // if (!empty($memberData['iosMemberIds']) && isset($templateData['engagementId'])) {
            // $this->createMemberNotifications($memberData['iosMemberIds'], $templateData['engagementId']);
            // }
            $device_token = $memberData['iosMemberTokens'];
            $chunks = array_chunk($device_token, 1000);
            foreach ($chunks as $chunk) {
                $param = [
                    'title'             => $templateData['notification_title'],
                    'message'           => $templateData['notification_description'],
                    'device_token'      => $chunk,
                    'auth_key'          => env("FCM_IOS_KEY"),
                    'action_type'       => $templateData['action_type'],
                    'action_id'         => $templateData['action_id'],
                    'device_type'       => 'ios',
                    // 'notification_id'   => $templateData['engagementId']
                    'notification_id'   => 0
                ];
                $resp = $this->sendFCM($param);

                Log::info(['Response for ios notification' => $resp]);

                $response = $response . $resp;
            }
        }
        return $response;
    }

    public function sendFCM(array $request)
    {
        $url = env("FCM_URL");
        $body_array = array("body" => $request['message'], "title" => $request['title'], "icon" => "myicon");
        $app_url = config('constants.WEBSITE_URL');
        $live_event_link = $app_url . '/liveEvent/';

        if ($request['action_type']) {

            if ($request['device_type'] == 'ios') {
                $body_array = array("body" => $request['message'], "title" => $request['title'], "icon" => "myicon", "mutable-content" => true, "content_available" => true);
            } else {
                $click_action = 'com.mymedisage.medisageapp.modules.HomeActivity';

                $body_array = array(
                    "body" => $request['message'], "title" => $request['title'], "icon" => "myicon",
                    "click_action" => $click_action
                );
            }

            $fields = array(
                'registration_ids' => $request['device_token'], 'notification' => $body_array,
                "data" => array(
                    "id" => $request['action_id'], "action" => $request['action_type'],
                    "notification_id" => $request['notification_id'],
                    "live_event_link" => ($request['action_type'] == 'live_event') ? $live_event_link : ''
                )
            );
        } else {
            if ($request['device_type'] == 'ios') {
                $body_array = array("body" => $request['message'], "title" => $request['title'], "icon" => "myicon", "mutable-content" => true, "content_available" => true);

                $fields = array('registration_ids' => $request['device_token'], 'notification' => $body_array);
            } else {
                $fields = array('registration_ids' => $request['device_token'], 'notification' => $body_array);
            }
        }


        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . $request['auth_key'],
            'Content-Type: application/json'
        );

        return UtilityHelper::postRequestToCommunication($url, $fields, $headers);
    }

    // public function createMemberNotifications($member_ids, $id, $notification_type = 'sent')
    // {
    //     Log::info(['Member_ids' => $member_ids]);
    //     if (isset($member_ids)) {
    //         $data = array();
    //         foreach ($member_ids as $member_id) {
    //             array_push($data, [
    //                 'member_id'         => $member_id,
    //                 'notification_id'   => $id,
    //                 'type'              => $notification_type,
    //                 'created_at'        => Carbon::now()
    //             ]);
    //         }

    //         foreach (array_chunk($data, 100) as $t) {
    //             $this->memberNotificatioService->store($t);
    //         }
    //     }

    //     return true;
    // }
}
