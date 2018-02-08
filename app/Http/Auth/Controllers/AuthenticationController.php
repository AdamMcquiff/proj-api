<?php

namespace App\Http\Auth\Controllers;

use App\Http\Users\Transformers\UserTransformer;
use App\Http\Base\Controllers\Controller;
use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticationController extends Controller
{
    use Helpers;

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
}