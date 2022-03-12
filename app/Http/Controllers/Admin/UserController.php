<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read users|create users|update users|delete users', ['only' => ['index','show', 'getUsers']]);
        $this->middleware('permission:create users', ['only' => ['store']]);
        $this->middleware('permission:update users', ['only' => ['edit','update']]);
        $this->middleware('permission:delete users', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**getUsers
     * @return mixed
     * @throws \Exception
     */
    public function getUsers()
    {
        $users = UserResource::collection(User::all());
        return datatables($users)->make(true);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        User::create($request->all());
        return response()->json(['status'=> true, 'message'=> 'User Stored Successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return response()->json(['status'=> true, 'message'=> 'Admin returned Successfully', 'data'=>$user]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest  $request
     * @param User $user
     * @return Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return response()->json(['status'=> true, 'message'=> 'User Updated Successfully']);
    }

    /**
     * Remove the specified useer from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['status'=>true,'message'=>__('User deleted successfully')],200);

    }
}
