<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

class HandleUserToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('user_token');

        if (!$token) {
            $token = (string)Str::uuid();

//            $request->cookies->set('user_token', $token);

            $response = $next($request);
            return $this->attachCookie($response, $token);
        }

        return $next($request);
    }

    protected function attachCookie(Response $response, string $token): Response
    {
        $cookie = new Cookie(
            'user_token',
            $token,
            time() + 60 * 60 * 24 * 30,
            '/',
            null,
            false,
            true,
            false,
            'lax'
        );

        return $response->withCookie($cookie);
    }
}
