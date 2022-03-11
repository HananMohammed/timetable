<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Admin;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Resources\Admin\RoleResource;

class RoleController extends Controller
{
    function __construct()
    {
          $this->middleware('permission:read roles|create roles|update roles|delete roles', ['only' => ['index','show', 'getRoles']]);
          $this->middleware('permission:create roles', ['only' => ['store']]);
          $this->middleware('permission:update roles', ['only' => ['edit','update']]);
          $this->middleware('permission:delete roles', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.roles.index', get_defined_vars());
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  RoleRequest $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create(['name'=>$request->name,'guard_name'=>'web']);
        $role->givePermissionTo($request->permissions);
        return response()->json(['status'=> true, 'message'=> 'Role Created Successfully']);
    }

    /**
     * getRoles.
     *
     * @return Response
     */
    public function getRoles()
    {
         $roles = RoleResource::collection(Role::all());
        return datatables($roles)->make(true);
    }

    /**
     * Show the form for editing the specified Role.
     *
     * @param  role $role
     * @return Response
     */
    public function edit(role $role)
    {
        $role->permissions = $role->getAllPermissions();
        return response()->json(['status'=> true, 'message'=> 'Role returned Successfully', 'data'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleRequest  $request
     * @param  Role $role
     * @return Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update(['name'=>$request->name ]);
        $role->syncPermissions($request->permissions);
        $role->syncPermissions($request->permissions);
        $admins = $role->admins;
        if(!empty($admins)){
            foreach($admins as $admin)
                $admin->syncPermissions($request->permissions);
        }
        return response()->json(['status'=> true, 'message'=> 'Role Updated Successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $admins = Admin::role($role->name)->get();
        $permissions = $role->permissions;
        foreach ($admins as $admin)
            $admin->revokePermissionTo($permissions);
        $role->revokePermissionTo($permissions);
        $role->delete();
        return response()->json(['status'=>true,'message'=>__('Role deleted successfully')],200);


    }
}
