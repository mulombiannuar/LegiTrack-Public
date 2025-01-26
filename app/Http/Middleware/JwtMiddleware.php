<?php

namespace App\Http\Middleware;

use App\Models\Admin\Order;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = null;
        $refreshedToken = null;

        try {
            // Try to authenticate the user using the JWT token
            $user = JWTAuth::parseToken()->authenticate();

            // Validate token claims
            $claims = JWTAuth::parseToken()->getPayload();
            $expectedAud = config('app.remote_base_url'); // Expected Audience
            $expectedKey = config('app.jwt_key'); // Expected key
            $expectedIss = config('app.url'); // Expected Issuer

            // Convert array to string for comparison if necessary
            $actualAud = $claims['aud'];
            if (is_array($actualAud)) {
                $actualAud = implode(', ', $actualAud);
            }

            if ($claims['iss'] !== $expectedIss || $actualAud !== $expectedAud || $claims['key'] !== $expectedKey) {
                return response()->json([
                    'status' => false,
                    'error' => 'token_invalid_claims',
                    'message' => 'Your token contains invalid claims. Please try again.',
                ], 401);
            }
        } catch (TokenInvalidException $e) {
            // Token is invalid
            return response()->json([
                'status' => false,
                'error' => 'token_invalid',
                'message' => 'Your token is invalid. Please try again.',
            ], 401);
        } catch (JWTException $e) {
            // Token not provided or another JWT-related error
            return response()->json([
                'status' => false,
                'error' => 'token_absent',
                'message' => 'Authentication token is missing. Please log in to access this resource.',
            ], 401);
        }

        // Attach the authenticated user to the request
        if ($user) {
            $request->merge(['user' => $user]);
        }

        // Proceed with the request
        $response = $next($request);

        // Attach the new token to the response headers if it was refreshed
        if ($refreshedToken) {
            $response->headers->set('Authorization', "Bearer $refreshedToken");
        }

        return $response;
    }
}
