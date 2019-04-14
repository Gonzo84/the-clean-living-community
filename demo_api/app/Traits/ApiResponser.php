<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponser {

    /**
     * Build success response
     * @param string|array
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse($data, $code = Response::HTTP_OK) {
        return response()->json(['data' => $data], $code);
    }

    /**
     * Build error response
     * @param string|array
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse($message, $code) {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}
