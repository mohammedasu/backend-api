<?php

namespace App\Repositories;

use App\Models\NotificationMaster;
use App\Constants\Constants;
use App\Helpers\UtilityHelper;
use Illuminate\Support\Facades\Log;

class NotificationMasterRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new NotificationMaster();
    }

    public function generateReferenceNumber()
    {
        return 'NOMA' . UtilityHelper::generateString();
    }

    public function getAll($request,$orderBy = [])
    {
        if(empty($orderBy)) {
            $orderBy[0] = 'id';
            $orderBy[1] = 'desc';
        }
        
        $notifications = $this->model->query();
        if($request->has('search')){
            $notifications->where('event_name','like', $request->search.'%')
            ->orWhere(function($query1) use($request){
                $query1->whereHas('email_template_name', function($query) use($request){
                    $query->where('name','like', $request->search.'%');
                    Log::info($request->search);
                });
            })
            ->orWhere(function($query1) use($request){
                $query1->whereHas('push_template_name', function($query) use($request){
                    $query->where('name','like', $request->search.'%');
                    Log::info($request->search);
                });
            })
            ->orWhere(function($query1) use($request){
                $query1->whereHas('sms_template_name', function($query) use($request){
                    $query->where('name','like', $request->search.'%');
                    Log::info($request->search);
                });
            })
            ->orWhere(function($query1) use($request){
                $query1->whereHas('page_template_name', function($query) use($request){
                    $query->where('name','like', $request->search.'%');
                    Log::info($request->search);
                });
            });
            // ->whereHas('sms_template_name', function($query) use($request){
            //     $query->orWhere('name','like', $request->search.'%');
            //     Log::info($request->search);
            // })
            // ->whereHas('push_template_name', function($query) use($request){
            //     $query->orWhere('name','like', $request->search.'%');
            //     Log::info($request->search);
            // })
            // ->whereHas('page_template_name', function($query) use($request){
            //     $query->orWhere('name','like', $request->search.'%');
            //     Log::info($request->search);
            // });
        }
        if($request->filter == 'trash'){
            $notifications->withTrashed()->whereNotNull('deleted_at');
        }else  if($request->filter == 'active'){
            $notifications->active();
        }else {
            $notifications->whereNull('deleted_at');
        }

        if($request->has('nopagination')){
            return $notifications->orderBy($orderBy[0],$orderBy[1])->get();
        } else {
            return $notifications->orderBy($orderBy[0],$orderBy[1])->paginate(Constants::PAGINATION_LENGTH);
        }
    }

    public function fetch($where) {
        return $this->model::withTrashed()->where($where)->first();
    }

    public function fetchWithType($where, $type) {
        return $this->model->where($where)->where($type)->first();
    }

    public function create($request) {
        $request['notification_master_ref_no'] = $this->generateReferenceNumber();
        return $this->model->create($request);
    }

    public function update($where,$request) {
        $entity = $this->model->where($where)->first();
        
        if (!empty($entity)) {
            $entity->update($request);
            return $entity->refresh();
        }
    }

    public function destroy($where)
    {
        return $this->model->where($where)->delete();
    }

    public function findwithTrash($template_ref_no) {
        return $this->model::withTrashed()->where('template_ref_no', $template_ref_no)->first();
    }

    public function restore($notification)
    {
        $notification->restore();
        return $notification;
    }
}
