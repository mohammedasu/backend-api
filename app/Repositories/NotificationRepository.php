<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Constants\Constants;

class NotificationRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Notification();
    }

    public function getAll($request)
    {
        $whatsapp = $this->model->query();
        if ($request->has('search')) {
            $whatsapp->where('engagement_name', 'like', '%' . $request->search . '%');
            $whatsapp->orWhere('notification_type', 'like', '%' . $request->search . '%');
        }
        if ($request->has('nopagination')) {
            // return $whatsapp->where(function($query) {
            //     if(!auth('api')->user()->hasRole('superadmin'))
            //         $query->where('created_by', auth('api')->user()->id);
            // })->orderBy('id', 'desc')->get();

            return $whatsapp->orderBy('id', 'desc')->get();
        }
        // return $whatsapp->where(function($query) {
        //     if(!auth('api')->user()->hasRole('superadmin'))
        //         $query->where('created_by', auth('api')->user()->id);
        // })->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);

        return $whatsapp->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
    }

    public function getInActive()
    {
        return $this->model->where('is_processed', false)->get();
    }

    public function store(array $params)
    {
        return $this->model->create($params);
    }

    public function getUnprocessedEngagement()
    {
        return $this->model->where('is_processed', false)
            ->whereNotNull('scheduled_timestamp')
            ->where('scheduled_timestamp', '<=', NOW())
            ->get();
    }

    public function update(array $params, Notification $notification)
    {
        $notification->update($params);
        return $notification->refresh();
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
    }

    public function fetch($where, $multiple = false)
    {
        if ($multiple) {
            return $this->model->where($where)->get();
        } else {
            return $this->model->where($where)->first();
        }
    }

    public function create($request)
    {
        return $this->model->create($request);
    }
}
