<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CustomAuth\Auth;

class LoginController extends Controller
{
    

    private Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Default action
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function action(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $valid = $this->auth->check($request->email);
        
        if ($valid) {
            return response()->json([
                'status' => true,
                'message' => 'Loggedin!',
                'token' => $this->auth->createToken(),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Unauthorized. Please make sure you have an account.',
            'token' => null,
        ], 403);

    }
}
