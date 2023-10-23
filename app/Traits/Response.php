<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Response {

    /**
     * @param array|object data object
     * @param string|int status code
     * @param string message
     * 
     * adds message and code field to response and converts response to json
     */
    public function response(
        array|object $data = [],
        string|int $code = 200,
        string $message = "Success"
        ) : JsonResponse {
            $res = [
                "status" => $code,
                "message" => $message,
                "body" => $data
            ];
        return response()->json($res, $code);
    }
}