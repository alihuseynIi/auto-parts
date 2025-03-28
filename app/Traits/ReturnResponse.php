<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ReturnResponse
{

    /**
     * @param int $statusCode
     * @param $data
     * @param string|null $message
     * @return JsonResponse
     */
    public function response(int $statusCode, $data = [], ?string $message = null): JsonResponse
    {

        $response = ['status_code' => $statusCode];
        if (isset($message)) {
            $response['message'] = $message;
        }

        $response['count'] = isset($data) ? count(json_decode(json_encode($data), 1)) : 0;
        $response['data'] = $data;

        return response()->json($response, $statusCode);
    }
}
