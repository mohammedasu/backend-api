<?php

namespace App\Services;

use App\Exceptions\CustomErrorException;
use App\Models\EmailEndpoint;
use App\Helpers\EmailHelper;
use App\Repositories\LiveEventMemberRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LiveEventMemberService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new LiveEventMemberRepository();
        $this->email_content_service = new EmailContentService();
        $this->partner_service = new PartnerService();
    }

    public function download($request, $live_event) {
        Log::info('LiveEventMemberService | download', $request->all());

        $data = $this->repository->download($request->all(), $live_event);
        $file_name = $live_event->link_id . '_registration.csv';
        if($data) {
            if ($live_event->is_survey_event == '1') {
                if ($live_event->link_id == 'ACS03') {

                    array_push(
                        $data['column_array'],
                        'In your clinical practice, which is the most preferred P2Y12 inhibitor in patients with ACS undergoing PCI?',
                        "On a scale of 1-5, how strongly do you believe, \" A single bioequivalence study in healthy
                                volunteers is sufficient clinical evidence to use generic Ticagrelor in ACS patients undergoing PCI”?"
                    );
                } elseif ($live_event->link_id == 'NTS02') {
                    array_push(
                        $data['column_array'],
                        'How important do you think is an early diagnosis of diabetic peripheral neuropathy?',
                        'How would you rate yourself on your knowledge of types of neuropathies?',
                        'How important do you think is an early diagnosis of diabetic peripheral neuropathy?'
                    );
                } else {
                    array_push(
                        $data['column_array'],
                        'Are you an existing MHL EQAS user?'
                        ,
                        ' '
                    );
                }
            }
        }

        $data['file_name'] = $file_name;
        return $data;
    }

    public function fetch($request, $event)
    {
        Log::info('LiveEventMemberService | fetch', $request);
        try {
            return $this->repository->fetchChunk($request,$event);
        } catch (\Exception $e) {
            throw new CustomErrorException($e);
        }
    }

    public function fetchMembers($where, $live_event) {
        Log::info('LiveEventMemberService | fetchMembers', $where);

        $live_event_member = $this->repository->fetch($where, true);
        $email_details = $this->email_content_service->fetch(['email_type' => 'live_event_success']);

        $subject = Str::replaceArray('F1', [$live_event->title], $email_details->subject);
        $app_url = config('app.url');
        $partner = $this->partner_service->show(['id' => $live_event->partner_id]);
        $partner_name = '';
        if ($partner) {
            $partner_name = $partner->title;
        }

        $image_link = '';
        if ($live_event->event_completed_image) {
            $image_link = config('constants.live_event_path') . $live_event->event_completed_image;
        }

        foreach ($live_event_member as $member) {
            $member_name = $member->fname;

            $email_html = $email_details->content;
            $email_html = Str::replaceArray('F3', [$image_link], $email_html);

            $email_html = Str::replaceArray('F1', [$member_name], $email_html);

            $email_html = Str::replaceArray('F2', [$app_url], $email_html);
            $email_html = Str::replaceArray('F2', [$app_url], $email_html);

            $email_html = Str::replaceArray('F4', [$live_event->title], $email_html);

            $email_html = Str::replaceArray('F5', [$partner_name], $email_html);


            $recipient_mail = $member->email;
            // if ($test_mail) {
            //     $recipient_mail = $test_mail;
            // }

            $response = EmailHelper::sendEmail($email_details, $member->id, $recipient_mail, $subject, $email_html);
            print_r("<pre>");
            print_r($response);

            // if ($test_mail) {
            //     return;
            // }

            return $response;
        }
    }

}
