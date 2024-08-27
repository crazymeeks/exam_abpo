<?php

namespace App\CustomAuth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jwt\Jwtoken;
use DateTimeImmutable;

class Auth
{


    private Jwtoken $jwt;
    
    /**
     * @var \App\Models\User|null
     */
    private $user = null;

    public function __construct(Jwtoken $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Check user credentials
     *
     * @param string $email
     * 
     * @return bool
     */
    public function check(string $email)
    {

        $user = User::where('email', $email)->first();
        
        $this->user = $user;

        if ($user) {
            return true;
        }

        return false;    
    }

    /**
     * Create token
     *
     * @return string
     */
    public function createToken()
    {

        if ($this->user) {
            $jwt = $this->jwt->encode($this->user);
            return $jwt;
        }

        throw new \Exception("Cannot generate token. User could not be found.");
    }
}