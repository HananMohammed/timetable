<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    use ResponseTrait;
    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password))
            return $this->validationError([ 'email' => [__('auth.failed')],]);

        $user->status= true;
        $user->token = $user->createToken('token-name', ['server:update'])->plainTextToken;

        return response()->json($user, 200);
    }

    /**this method signs out users by removing tokens
     * @param Request $request
     */
    public function signout(Request $request) :void
    {
        $request->user()->currentAccessToken()->delete();
    }



}
