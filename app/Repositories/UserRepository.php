<?php

namespace App\Repositories;

use App\Constants\Constants;
use App\Models\AdminLogin;

class UserRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new AdminLogin();
    }

    public function getAll($request)
    {
        $users = $this->model->query();
        if($request->has('search')){
            $users->where('username','like', $request->search.'%');
        }
        if($request->filter == 'trash'){
            $users->withTrashed()->whereNotNull('deleted_at');
        }else  if($request->filter == 'active'){
            $users->active();
        }else {
            $users->whereNull('deleted_at');
        }
        
        if($request->has('nopagination')){
            return $users->where(function($query) {
                if(!auth('api')->user()->hasRole('superadmin'))
                    $query->where('created_by', auth('api')->user()->id);
            })->orderBy('id','desc')->get();
        } else {
            return $users->where(function($query) {
                if(!auth('api')->user()->hasRole('superadmin'))
                    $query->where('created_by', auth('api')->user()->id);
            })->orderBy('id','desc')->paginate(Constants::PAGINATION_LENGTH);
        }
    }

    public function create($request) {
        return $this->model->create($request);
    }

    public function find($id) {
        return $this->model->find($id);
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

    public function findwithTrash($id) {
        return $this->model::withTrashed()->find($id);
    }

    public function restore($user)
    {
        $user->restore();
        return $user;
    }
}
