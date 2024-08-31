<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use App\Models\EmailEndpoint;

class EmailHelper
{
    public static function sendEmail($email_details, $member_id, $to_email, $subject, $html_body)
    {
        $credentials = EmailEndpoint::find($email_details->endpoint_id);

        if ($credentials['user_name'] == 'Medisage_Trans') {
            $params = [
                'version' => "1.0",
                'userName' => $credentials->user_name,
                'password' => $credentials->password,
                "includeFooter" => "false",
                'message' => [
                    'custRef' => $member_id,
                    'html' => $html_body,
                    'text' => $email_details->content,
                    'subject' => $subject,
                    'fromEmail' => $email_details->from,
                    'fromName' => 'Medisage',
                    'replyTo' => $email_details->replyTo,
                    'recipient' => $to_email
                ]
            ];
            try {
                $response = Http::post($credentials->url, $params);
                $response_data = $response->json();

                Log::info(['Email api response ' => $response_data]);

                if ($response_data['requestStatus'] == 'success' && $response_data['statusCode'] == '200') {
                    Log::info(['Email response description ' => $response_data['statusDesc']]);
                    return ['status' => "success", 'message' => 'email_sent'];
                } else {
                    return ['status' => "failed", 'message' => 'Invalid email address'];
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return ['status' => "failed", 'message' => $e->getMessage()];
            }
        } else if ($credentials['user_name'] == 'AWS_SES') {

            $request_id = random_int(1000000, 9999999);

            try {
                $response = Http::withBasicAuth(Config::get('constants.communication_api_username'), Config::get('constants.communication_api_password'))
                    ->withHeaders([
                        'x-request-id' => $request_id,
                    ])->post($credentials->url, [
                        'to_email' => $to_email,
                        'subject' => $subject,
                        'html_body' => $html_body,
                    ]);

                Log::info(["email api response from communication service" => $response->body()]);
                $response_body = \GuzzleHttp\json_decode($response->body());

                return ['status' => $response_body->success ? 'success' : 'failed', 'message' => $response_body->message, 'http_code' => $response_body->http_code];
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return ['status' => "failed", 'message' => $e->getMessage()];
            }
        }
    }
}
