<?php

namespace App\Repositories;

use App\Models\Comments;
use App\Constants\Constants;
use Carbon\Carbon;

class CaseCommentRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Comments();
    }

    public function getAll($request,$orderBy = [])
    {
        if(empty($orderBy)) {
            $orderBy[0] = 'id';
            $orderBy[1] = 'desc';
        }

        $cases = $this->model->query();
        if($request->has('id')){
            $cases->where('id', $request->id);
        }
        if ($request->filter == 'trash') {
            $cases = $cases->withTrashed();
        }

        if ($request->has('search') && $request->filled('search')) {
            $cases->where('title', 'LIKE', '%' . $request->search . '%');
            $cases->orWhere('link_id', 'LIKE', '%' . $request->search . '%');
            $cases->orWhere('description', 'LIKE', '%' . $request->search . '%');
        }

        if($request->has('nopagination')){
            return $cases->orderBy($orderBy[0],$orderBy[1])->get();
        } else {
            return $cases->orderBy($orderBy[0],$orderBy[1])->paginate(Constants::PAGINATION_LENGTH);
        }
        
    }

    public function fetch($where) {
        return $this->model->where($where)->first();
    }
    
    public function create($request) {
        return $this->model->create($request);
    }

    public function findwithTrash($id) {
        return $this->model::withTrashed()->find($id);
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

    public function restore($case)
    {
        $case->restore();
        return $case;
    }

    public function updateWithTrashed($where,$request)
    {
        $entity = $this->model::withTrashed()->where($where)->first();

        if (!empty($entity)) {
            $entity->update($request);
            return $entity->refresh();
        }
    }

    public function findWithTodayDate() {
        return $this->model->whereDate('created_at', Carbon::today())->withTrashed()->count() + 1;
    }
}
