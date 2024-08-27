<?php

namespace App\Http\Controllers\Page;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    
    /**
     * Login page for ui
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $client = new \Google_Client();
        $client->setClientId(config('google.client_id'));
        $client->setClientSecret(config('google.client_secret'));
        $client->setRedirectUri(config('google.redirect_uri'));
        $client->addScope('email');
        $client->addScope('profile');

        $googleAuthUrl = $client->createAuthUrl();
        $email = null;

        if ($request->has('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($request->code);
            $client->setAccessToken($token['access_token']);
    
            // get profile info 
            $google_oauth = new \Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            $email =  $google_account_info->email;
            $name =  $google_account_info->name;
            $user = User::where('email', $email)->first();
            if ($user) {
                $email = $user->email;
            }
        }
        
        return view('login', compact('googleAuthUrl', 'email'));
    }
}
