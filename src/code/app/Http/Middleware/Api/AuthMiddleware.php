<?php

namespace App\Http\Middleware\Api;

use Closure;
use App\Jwt\Jwtoken;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Middleware\Api\AuthHeaderTrait;

class AuthMiddleware
{
    use AuthHeaderTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $this->validateHeaderAuthorization($request);

        $jwt = app(Jwtoken::class);

        $obj = $jwt->decode($token);
        
        try {
            if (!property_exists($obj, 'email')) {
                throw new \Exception("Unauthorized!");
            }
            $user = User::where('email', $obj->email)->first();
    
            if (!$user) {
                throw new \Exception("Unauthorized!");
            }
    
            return $next($request);

        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}
