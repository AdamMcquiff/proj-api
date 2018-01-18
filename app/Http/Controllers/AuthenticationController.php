<?php

namespace App\Http\Controllers;

use App\UserTransformer;
use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticationController extends Controller
{
    use Helpers;

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        // all good so return the token
//        return ;

        return $this->response->item(auth()->user(), new UserTransformer)
            ->addMeta('token', JWTAuth::fromUser(auth()->user()));
    }
}