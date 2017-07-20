<?php

namespace App\Http\Middleware;

use App\Cart;
use Closure;
use Illuminate\Support\Facades\Password;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('token') !== null) {
            $token = $request->input('token');
            if (Cart::where('token', $token)->first() !== null) {
                return $next($request);
            } else {
                return response()->json(['error' => 'invalid_token'], 401);
            }
        } else {
            $token = Password::getRepository()->createNewToken();
            $cart = new Cart;
            $cart->token = $token;
            $cart->save();
            return response()->json(['token' => $token]);
        }
    }
}
