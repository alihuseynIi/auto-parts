<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ExceptionTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthService
{
    use ExceptionTrait;

    /**
     * @param Request $request
     * @return array|string[]
     */
    public function login(Request $request): array
    {
        $credentials = ["email" => $request->input("email"), "password" => $request->input("password")];

        if (!Auth::attempt($credentials)) {
            return ["message" => "Email və ya şifrə yanlışdır"];
        }

        $captchaToken = $request->input('captcha_token');
        $projectId  = env('RECAPTCHA_ENTERPRISE_PROJECT_ID');
        $apiKey     = env('RECAPTCHA_ENTERPRISE_API_KEY');
        $siteKey    = env('RECAPTCHA_ENTERPRISE_SITE_KEY');

        $enterpriseResponse = Http::post(
            "https://recaptchaenterprise.googleapis.com/v1/projects/{$projectId}/assessments?key={$apiKey}",
            [
                'event' => [
                    'token'          => $captchaToken,
                    'siteKey'        => $siteKey,
                    'expectedAction' => 'login',
                ],
            ]
        );

        $captchaResult = $enterpriseResponse->json();

        if (
            !isset($captchaResult['tokenProperties']['valid']) ||
            $captchaResult['tokenProperties']['valid'] !== true
        ) {
            return ['message' => 'reCAPTCHA is invalid.'];
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

