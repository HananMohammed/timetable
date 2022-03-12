<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Resources\Admin\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read admins|create admins|update admins|delete admins', ['only' => ['index','show', 'getAdmins']]);
        $this->middleware('permission:create admins', ['only' => ['store']]);
        $this->middleware('permission:update admins', ['only' => ['edit','update']]);
        $this->middleware('permission:delete admins', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.admins.index', get_defined_vars());
    }

    /**
     * getAdmins.
     *
     * @return Response
     */
    public function getAdmins()
    {
        $admins = AdminResource::collection(Admin::all());
        return datatables($admins)->make(true);
    }

    /**
     * Store a newly created Admin in storage.
     *
     * @param Request  $request
     * @return Response
     */
    public function store(AdminRequest $request)
    {
        $admin = Admin::create($request->all());
        $role = Role::where('id',$request->role)->first();
        if($role){
            $permissions = $role->permissions;
            $admin->syncRoles($role);
            $admin->syncPermissions($permissions);
        }
        return response()->json(['status'=> true, 'message'=> 'Admin Stored Successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $admin->role = @$admin->roles()->first()->id;
        return response()->json(['status'=> true, 'message'=> 'Admin returned Successfully', 'data'=>$admin]);
    }

    /**
     * Update the specified Admin in storage.
     *
     * @param  AdminRequest $request
     * @param  Admin $admin
     * @return Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $role = Role::where('id',$request->role)->first();
        $admin->syncRoles($role);
        $permissions = $role->permissions;
        $admin->syncPermissions($permissions);
        $admin->update($request->all());
        return response()->json(['status'=> true, 'message'=> 'Admin Updated Successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Admin $admin
     * @return Response
     */
    public function destroy(Admin $admin)
    {
        $role = $admin->roles()->first();
        if($role){
            $permissions = $role->permissions;
            $admin->revokePermissionTo($permissions);
            $role->revokePermissionTo($permissions);
        }
        $admin->delete();
        return response()->json(['status'=>true,'message'=>__('Admin deleted successfully')],200);
    }
}
