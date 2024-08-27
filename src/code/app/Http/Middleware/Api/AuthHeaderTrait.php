<?php


namespace App\Http\Middleware\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

trait AuthHeaderTrait
{


    /**
     * Validate authorization header
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return string
     */
    public function validateHeaderAuthorization(Request $request)
    {
        $authorization = $request->headers->get('Authorization');
        if ($authorization) {
            $exploded = array_filter((explode(' ', $authorization)));
            
            if (count($exploded) <= 1) {
                throw new Exception("Invalid or missing Authorization header");
            }
    
            if ($exploded[0] != 'Bearer') {
                throw new Exception(sprintf("Invalid Authorization Bearer. Format must be Authorization: Bearer. {%s} found.", "Authorization: bearer"));
            }
            
            $token = array_pop($exploded);
    
            return $token;
        }

        throw new Exception("Authorization header name cannot be found!");
    }


    // /**
    //  * Get current authenticated user
    //  *
    //  * @param \Illuminate\Http\Request  $request
    //  * @param \stdClass $decodedToken
    //  * 
    //  * @return \App\Models\User
    //  */
    // public function getCurrentUser($request, $decodedToken)
    // {
    //     if (!$request->has('user')) {
    //         $user = User::whereUuid($decodedToken->data->uuid)->first();
    //     } else {
    //         $user = $request->user;
    //     }
    //     return $user;
    // }
}