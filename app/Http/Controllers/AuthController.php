<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuthController extends Controller
{
    /**
     * @param AuthService $authService
     */
    public function __construct(private AuthService $authService)
    {
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $login = $this->authService->login($request);
            if (!empty($login["message"])) {
                return $this->response(Response::HTTP_UNAUTHORIZED, [], $login["message"]);
            }
            return $this->response(Response::HTTP_OK, $login);
        } catch (Throwable $exception) {
            $this->logException($exception);
            return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, [], __("messages.auth.login_user_error"));
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            $this->authService->logout();
            return $this->response(Response::HTTP_OK, [], __("messages.auth.logout_user"));
        } catch (Throwable $exception) {
            $this->logException($exception);
            return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, [], __("messages.auth.logout_user_error"));
        }
    }

    /**
     * @return JsonResponse
     */
    public function getUserDetails(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, new UserResource($this->authService->getUserDetails()));
        } catch (Throwable $exception) {
            $this->logException($exception);
            return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, [], __("messages.auth.login_user_error"));
        }
    }
}
