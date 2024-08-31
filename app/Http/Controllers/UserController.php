<?php
    
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeUserRequest;
use App\Http\Requests\updateUserRequest;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\AdminLogin;
use App\Services\RoleService;
use App\Services\UserService;
    
class UserController extends Controller
{
    public function __construct() {

        $this->middleware('permission:admin-user', ['only' => ['index']]);
        $this->middleware('permission:add-admin-user', ['only' => ['store','create']]);
        $this->middleware('permission:edit-admin-user', ['only' => ['show','update','create']]);
        $this->middleware('permission:delete-admin-user|restore-admin-user', ['only' => ['destroy','restore']]);

        $this->role_service = new RoleService();
        $this->user_service = new UserService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->user_service->getUser($request);

        return ApiResponse::successResponse('Get All Users', new UserCollection($users));

    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $roles = $this->role_service->getRole($request);

        return ApiResponse::successResponse('Get All Roles', new RoleCollection($roles));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeUserRequest $request)
    {
        $request['ip_address'] = $request->ip();
        $user = $this->user_service->store($request);

        return ApiResponse::successResponse('User created successfully', new UserResource($user));

    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $request['id'] = $id;
        $request['nopagination'] = 1;
        $user = $this->user_service->show($request);

        return ApiResponse::successResponse('Get Specific Users', $user);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request['id'] = $id;
        $user = $this->user_service->show($request);

        return ApiResponse::successResponse('Get Specific Users', $user);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateUserRequest $request, AdminLogin $admin_user)
    {
        $request['id'] = $admin_user->id;
        $user = $this->user_service->update($request);
        
        return ApiResponse::successResponse('User updated successfully', new UserResource($user));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user_service->destroy($id);
        return ApiResponse::successResponse('User deleted successfully');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $this->user_service->restore($id);
        return ApiResponse::successResponse('User restore successfully');
    }
}