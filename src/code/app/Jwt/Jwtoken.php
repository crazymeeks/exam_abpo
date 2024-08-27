<?php

namespace App\Jwt;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;
use DateTimeImmutable;

class Jwtoken
{


    const JWT_ALGO = 'HS256';

    /**
     * Create token
     *
     * @param \App\Models\User
     * 
     * @return string
     */
    public function encode(User $user)
    {

        $jwt = JWT::encode($this->createJWTPayload($user), config('jwt.key'), self::JWT_ALGO);

        return $jwt;
    }

    /**
     * Decode the token
     *
     * @param string $token
     * 
     * @return \stdClass
     */
    public function decode(string $token)
    {

        $decoded = JWT::decode($token, new Key(config('jwt.key'), self::JWT_ALGO));
        
        return $decoded;
    }

    /**
     * Create JWT payload
     *
     * @param string $expiresAt
     * 
     * @return array
     */
    protected function createJWTPayload(User $user, string $expiresAt = '+60 minutes')
    {
        $issuedAt = new DateTimeImmutable();

        $expire = $issuedAt->modify($expiresAt)->getTimestamp();
        
        $payload = array_merge([
            'iss' => config('app.url'),
            'aud' => config('app.url'),
            'iat' => strtotime(now()), // timestamp of token issuing
            'nbf' => strtotime(now()), // timestamp of when the token should start being considered valid. Should be equal to or greater than iat.
            'exp' => $expire

        ], ['email' => $user->email]);

        return $payload;
    }
}