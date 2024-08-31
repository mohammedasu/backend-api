<?php

namespace App\Repositories;

use App\Models\LiveEvent;
use App\Constants\Constants;

class LiveEventRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new LiveEvent();
    }

    public function getAll($request)
    {
        $live_event = $this->model->query();

        $live_event = $live_event->with('subscription');
        if ($request->filter == 'trash') {
            $live_event = $live_event->whereNotNull('deleted_at');
        } else if ($request->filter == 'active') {
            $live_event = $live_event->where('is_active', '=', '1');
        } else {
            $live_event = $live_event->whereNull('deleted_at');
        }
        if ($request->has('search')) {
            $live_event->where('title', 'LIKE', $request->search . '%');
            $live_event->orWhere('live_event_text', 'LIKE', $request->search . '%');
            $live_event->orWhere('link_id', 'LIKE', $request->search . '%');
        }
        $live_event = $live_event->orderBy('id', 'desc');
        
        if ($request->has('nopagination')) {
            return $live_event->get();
        }
        return $live_event->paginate(Constants::PAGINATION_LENGTH);
    }

    public function getMemberLiveEventRewards($member)
    {
        $rewards = LiveEvent::with(['event_members', 'member_certificates'])
            ->whereHas('event_members', function ($q) use ($member) {
                return $q->where('mobile_number', $member->mobile_number)
                    ->where('visited_during_session', true)->latest();
            })->whereHas('member_certificates', function ($q) use ($member) {
                return $q->where('member_id', $member->id);
            })->where('has_certificates', true)
            ->sum('rewards');
        return $rewards;
    }

    public function fetch($where)
    {
        return $this->model->where($where)->first();
    }

    public function create($params) {
        return $this->model->create($params);
    }

    public function updateOrCreate($params) {
        return $this->model->updateOrCreate($params);
    }

    public function update($where, $params) {
        $entity = $this->model->where($where)->first();
        if(!empty($entity)) {
            $entity->update($params);
            return $entity->refresh();
        }
    }

    public function destroy($where) {
        return $this->model->where($where)->delete();
    }
}
