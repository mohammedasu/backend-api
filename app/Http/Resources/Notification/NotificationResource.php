<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $response = json_decode($this->response);
        $result = null;
        if ($response && !empty($response->results)) {
            $result = $this->getResult($response->results);
        }

        $failure = $response ? $response->failure : 0;
        $success = $response ? $response->success : 0;
        return [
            'id'                => $this->id,
            'notification_type' => $this->notification_type,
            'count'             => $this->count,
            'failure'           => $failure,
            'success'           => $success,
            'result'            => $result,
            'engagement_name'   => $this->engagement_name,
            'scheduled_time'    => $this->scheduled_timestamp,
            'is_processed'      => $this->is_processed,
            'data_filter_id'    => $this->data_filter_id,
            'import_csv'        => $this->import_csv,
            'payload'           => $this->payload,
            'action_type'       => $this->action_type,
            'device_type'       => $this->device_type,
            'action_id'         => $this->action_id,
            'created_at'        => !empty($this->created_at) ? date('Y-m-d H:i:s', strtotime($this->created_at)) : null
        ];
    }

    public function getResult($results)
    {
        $failure_res    = [];
        $success_count  = 0;
        foreach ($results as $value) {
            $error_present = false;
            if (isset($value->error)) {
                foreach ($failure_res as $key => $f_res) {
                    if ($failure_res[$key]['res_message'] == $value->error) {
                        $error_present = true;
                        $failure_res[$key]['res_count'] = $failure_res[$key]['res_count'] + 1;
                        break;
                    }
                }
                if (!$error_present) {
                    array_push(
                        $failure_res,
                        [
                            'res_message'   => $value->error,
                            'res_count'     => 1,
                        ]
                    );
                }
            } else if (isset($value->message_id)) {
                $success_count++;
            }
        }
        return [
            'failure' => $failure_res,
            'success' => [
                'res_message'   => 'Successfully sent.',
                'count'         => $success_count,
            ]
        ];
    }
}
