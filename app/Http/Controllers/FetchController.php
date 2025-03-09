<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Requests\GetCategoriesRequest;
use App\Http\Requests\SearchProductsRequest;
use App\Http\Resources\CategoriesResourceCollection;
use App\Services\FetchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class FetchController extends Controller
{
    /**
     * @param FetchService $fetchService
     */
    public function __construct(private FetchService $fetchService)
    {
    }

    /**
     * @param GetCategoriesRequest $request
     * @return JsonResponse
     */
    public function getCategories(GetCategoriesRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, new CategoriesResourceCollection($this->fetchService->getCategories($request->input("category_id"))));
        } catch (Throwable $exception) {
            $this->logException($exception);
            return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, [], __("messages.response.error"));
        }
    }

    /**
     * @param SearchProductsRequest $request
     * @return JsonResponse
     */
    public function searchProducts(SearchProductsRequest $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, $this->fetchService->searchProducts($request));
        } catch (Throwable $exception) {
            $this->logException($exception);
            return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, [], __("messages.response.error"));
        }
    }

    /**
     * @return JsonResponse
     */
    public function getSliders(): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, $this->fetchService->getSliders());
        } catch (Throwable $exception) {
            $this->logException($exception);
            return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, [], __("messages.response.error"));
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getOrders(Request $request): JsonResponse
    {
        try {
            return $this->response(Response::HTTP_OK, $this->fetchService->getOrders($request));
        } catch (Throwable $exception) {
            $this->logException($exception);
            return $this->response(Response::HTTP_INTERNAL_SERVER_ERROR, [], __("messages.response.error"));
        }
    }
}
