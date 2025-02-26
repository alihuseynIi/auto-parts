<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ExceptionTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    use ExceptionTrait;

    /**
     * @param Request $request
     * @return array
     */
    public function login(Request $request): array
    {
        $credentials = ["email" => $request->input("email"), "password" => $request->input("password")];

        if (!Auth::attempt($credentials)) {
            return ["message" => "Email və ya şifrə yanlışdır"];
        }

        return $this->createTokenResponse(Auth::user());
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        Auth::user()->currentAccessToken()->delete();
    }

    /**
     * @return Authenticatable
     */
    public function getUserDetails(): Authenticatable
    {
        return User::query()->with("addresses")->withCount('cartItems')->find(Auth::id());
    }


    /**
     * @param object $user
     * @return array
     */
    private function createTokenResponse(object $user): array
    {
        $token = $user->createToken("api-token")->plainTextToken;

        if (!$token) {
            return ["message" => __("messages.auth.creating_token_error")];
        }

        return ["user_id" => $user->id, "access_token" => $token];
    }
}

