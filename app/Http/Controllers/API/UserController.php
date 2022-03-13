<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserResource;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseTrait;

    public function getUser(Request $request){

        $user = $request->user();
        $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;

        return $this->returnData('user',new UserResource($user),'User Signed In Successfully ');
    }


}
