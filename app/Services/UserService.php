<?php

namespace App\Services;

use App;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomErrorException;
use App\Http\Resources\Permission\PermissionCollection;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Services\RoleService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $repository;

    public function __construct()
    {
        $this->role_service = new RoleService();
        $this->repository = new UserRepository();
    }

    /**
     * Function to fetch User list
     * @param $request
     */

    public function getUser($request)
    {
        
        $data = $this->repository->getAll($request);
        if(!$data) {
            throw new CustomErrorException(null, 'Something Went Wrong in Fetching User.', 500);
        }

        return $data;
    }

    /**
     * Function To show User
     * @param $request
     */
    public function show($request){

        $user = $this->repository->find($request->id);
        $roles = $this->role_service->getRole($request);
        $userRole = $user->roles->pluck('name','name')->all();

        $array = ['user' => new UserResource($user) , 'roles' => new RoleCollection($roles), 'userRole' => $userRole];
        return $array;
    }

    /**
     * Function to store User details
     * @param $request
     */

    public function store($request)
    {
        Log::info('UserService | store', $request->all());
        
        $params = $request->all();
        $params['password'] = Hash::make($params['password']);
        $params['type'] = 'admin';
        $params['created_from'] = 'admin';
        $params['created_by'] = auth('api')->user()->id;
        unset($params['confirm_password']);
        unset($params['role']);

        $user = $this->repository->create($params);
        if(!$user) {
            throw new CustomErrorException(null, 'Something went wrong with create user', 500);
        }

        $user->assignRole($request->input('role'));

        return $user;
    }

    /**
     * Function to update User details
     * @param $request
     */

    public function update($request)
    {
        Log::info('UserService | update', $request->all());

        $where = ['id' => $request->id];
        $params = $request->all();
        if(!empty($params['password'])){ 
            $params['password'] = Hash::make($params['password']);
        }else{
            unset($params['password']);    
        }
        unset($params['confirm_password']);
        unset($params['role']);
        unset($params['role_name']);
        $user = $this->repository->update($where,$params);
        if(!$user) {
            throw new CustomErrorException(null, 'User updation failed', 500);
        }

        DB::table('model_has_roles')->where('model_id',$request->id)->delete();
    
        $user->assignRole($request->input('role'));

        return $user;
    }

    /**
     * Function to destroy User details
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        $where = ['id' => $id];
        $user = $this->repository->destroy($where);
        if(!$user) {
            throw new CustomErrorException(null,'Something went wrong in role deletion.', 500);
        }

        return $user;
    }

    /**
     * Function to restore User details
     * @param $id
     * @return bool
     */
    public function restore($id)
    {
        $user = $this->repository->findwithTrash($id);
        if(!empty($user)){
            $user->deleted_at = null;
            $user = $this->repository->restore($user);
        }
     
        if(!$user) {
            throw new CustomErrorException(null,'Something went wrong in user restore.', 500);
        }

        return $user;
    }
}
