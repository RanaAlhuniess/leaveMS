<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function respond($data, int $statusCode = 200, array $headers = []): JsonResponse
    {
        return response()->json($data, $statusCode, $headers);
    }

    protected function respondError($message, int $statusCode = 404): JsonResponse
    {
        return $this->respond([
            'message' => $message
        ], $statusCode);
    }
}
