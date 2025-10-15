<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Generic API response helper used by controllers.
     * Automatically infers status by HTTP code if not explicitly provided.
     */
    protected function apiResponse($data = null, string $message = 'Success', int $code = 200, ?string $status = null)
    {
        if ($status === null) {
            $status = $code >= 400 ? 'error' : 'success';
        }

        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function successResponse($data, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    protected function errorResponse($message = 'Error', $code = 400)
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message
        ], $code);
    }
}
