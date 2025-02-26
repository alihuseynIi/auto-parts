<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Resources\CartProductsResource;
use App\Services\CommonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CommonController extends Controller
{
    /**
     * @param CommonService $commonService
     */
    public function __construct(private CommonService $commonService)
    {
    }

    /**
     * @param CartRequest $request
     * @return JsonResponse
     */
    public function addToCart(CartRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, $this->commonService->addToCart($request));
        } catch (Throwable $exception) {
            $this->logException($exception);
            return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, [], __("messages.response.error"));
        }
    }

    /**
     * @param CartRequest $request
     * @return JsonResponse
     */
    public function removeFromCart(CartRequest $request): JsonResponse
    {
        try {
            $this->commonService->removeFromCart($request);
            return $this->response(Response::HTTP_OK, message: __("messages.cart.removed"));
        } catch (Throwable $exception) {
            $this->logException($exception);
            return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, [], __("messages.response.error"));
        }
    }

    /**
     * @param CartRequest $request
     * @return JsonResponse
     */
    public function getCartProducts(Request $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, CartProductsResource::collection( $this->commonService->getCartProducts($request->user())));
        } catch (Throwable $exception) {
            $this->logException($exception);
            return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, [], __("messages.response.error"));
        }
    }
}
