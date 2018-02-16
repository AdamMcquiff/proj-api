<?php

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Requests\RegisterUserRequest;
use App\Http\Users\Models\User;
use App\Http\Users\Transformers\UserTransformer;
use App\Http\Base\Controllers\Controller;
use Dingo\Api\Contract\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return $this->response->item(auth()->user(), new UserTransformer)
            ->addMeta('token', JWTAuth::fromUser(auth()->user()));
    }

    public function register(RegisterUserRequest $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $username = $request->input('username');
        $password = bcrypt($request->input('password'));
        User::create(compact('name','email', 'username', 'password'));

        return $this->response->item(auth()->user(), new UserTransformer);
    }
}