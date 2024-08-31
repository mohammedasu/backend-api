<?php

namespace App\Services;

use App\Exceptions\CustomErrorException;
use App\Repositories\NotificationMasterRepository;
use Illuminate\Support\Facades\Log;

class NotificationMasterService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new NotificationMasterRepository();
    }

    /**
     * Function to fetch Email template list
     * @param $request
     */

    public function fetchAll($request)
    {
        Log::info('NotificationMasterService | fetchAll', $request->all());

        $data = $this->repository->getAll($request);
        if(!$data) {
            throw new CustomErrorException(null, 'Something Went Wrong in Fetching Notification.', 500);
        }

        return $data;
    }

    /**
     * Function to show Email Template
     * @param $request
     */

    public function show($id)
    {
        Log::info('NotificationMasterService | show', ['notification_master_ref_no' => $id]);

        $where = ['notification_master_ref_no' => $id];
        $data = $this->repository->fetch($where);
        if(!$data) {
            throw new CustomErrorException(null, 'Something Went Wrong in Fetching Notification.', 500);
        }

        return $data;
    }

    /**
     * Function to store Email Template details
     * @param $request
     */

    public function store($request)
    {
        Log::info('NotificationMasterService | store', $request->all());
        
        $params = $this->emailTemplateRequest($request);

        $notification = $this->repository->create($params);
        if(!$notification) {
            throw new CustomErrorException(null, 'Something went wrong with storing Notification', 500);
        }

        return $notification;
    }

    /**
     * Function to update Email Template details
     * @param $request
     */

    public function update($request)
    {
        Log::info('NotificationMasterService | update', $request->all());

        $where = ['notification_master_ref_no' => $request->notification_master_ref_no];
        
        $params = $this->emailTemplateRequest($request);
        unset($params['created_from']);
        unset($params['created_by']);
        $notification = $this->repository->update($where,$params);
        if(!$notification) {
            throw new CustomErrorException(null, 'Something went wrong with updating Notification', 500);
        }
        
        return $notification;
    }

    public function updateStatus($request)
    {
        Log::info('NotificationMasterService | updateStatus', $request->all());
        $params = ['is_active' => $request->is_active];
        $where = ['notification_master_ref_no' => $request->notification_master_ref_no];
        
        return $this->repository->update($where,$params);
    }

    /**
     * Function to destroy Email Template details
     * @param $id
     * @return bool
     */
    public function destroy($request)
    {
        Log::info('NotificationMasterService | destroy', $request->all());
        
        $where = ['notification_master_ref_no' => $request->notification_master_ref_no];
        $params = ['is_active' => 0];
        $this->repository->update($where,$params);
        return $this->repository->destroy($where); 
    }

    /**
     * Function to restore Email Template details
     * @param $id
     * @return bool
     */
    public function restore($id)
    {
        $notification = $this->repository->findwithTrash($id);
        if(!empty($notification)){
            $notification->deleted_at = null;
            $notification = $this->repository->restore($notification);
        }
     
        if(!$notification) {
            throw new CustomErrorException(null,'Something went wrong in notification restore.', 500);
        }

        return $notification;
    }

    public function emailTemplateRequest($request) {
        return  [
            'event_name'                        => $request->event_name,
            'email_template_ref_no'             => $request->email_template_ref_no ?? null,
            'sms_template_ref_no'               => $request->sms_template_ref_no ?? null,
            'push_notification_template_ref_no' => $request->push_notification_template_ref_no,
            'page_notification_template_ref_no' => $request->page_notification_template_ref_no,
            'created_from'                      => 'admin',
            'created_by'                        => auth('api')->user()->id
        ];
    }
}
