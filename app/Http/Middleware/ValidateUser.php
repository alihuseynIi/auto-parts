<?php

namespace App\Http\Middleware;

use App\Traits\ExceptionTrait;
use App\Traits\ReturnResponse;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateUser
{
    use ReturnResponse, ExceptionTrait;

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Retrieve the authenticated user from the token
        $user = $request->user();

//        // Check user is blocked or not
//        if ($user->blocked) {
//            return $this->response(Response::HTTP_FORBIDDEN, [], __("messages.auth.blocked"));
//        }

        // Get user_id from the request (adjust this according to how you're passing the user_id)
        $userIdToCheck = $request->input('user_id');

        // Check is user_id exists
        if (empty($userIdToCheck)) {
            return $this->response(Response::HTTP_UNPROCESSABLE_ENTITY, [], __("messages.auth.id_required"));
        }

        // Check if the user exists and the IDs match
        if (!$user || $user->id != $userIdToCheck) {
            // Return an unauthorized response or any other response you prefer
            return $this->response(Response::HTTP_UNAUTHORIZED, [], __("messages.auth.token_not_belongs_to_user"));
        }

        // Proceed with the request
        return $next($request);
    }
}
