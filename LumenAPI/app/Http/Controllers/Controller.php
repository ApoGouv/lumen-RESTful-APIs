<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;

class Controller extends BaseController
{
    /**
     * $data: The response data
     * $code: The HTTP response code
     */
    public function createSuccessResponse($data, $code){
        return response()->json(['data' => $data], $code);
    }

    /**
     * $message: The error message
     * $code (in message body): Error code included with error message body 
     * $code (after message): The HTTP response code
     */
    public function createErrorResponse($message, $code){
        return response()->json(['message' => $message, 'code' => $code], $code);
    }


    protected function buildFailedValidationResponse(Request $request, array $errors) {
        return $this->createErrorResponse($errors, 422);
    }
}
