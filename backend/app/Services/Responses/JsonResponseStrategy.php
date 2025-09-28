<?php

namespace App\Services\Responses;

use App\Contracts\ResponseStrategy;
use App\Enums\ResponseStatus;
use Illuminate\Http\JsonResponse;

class JsonResponseStrategy implements ResponseStrategy
{
    private function makeResponse(string $message, array $payload): array
    {
        $response = [
            'message' => $message,
        ];

        foreach ($payload as $key => $value) {
            $response[$key] = $value;
        }

        return $response;
    }

    public function send(string $message, array $payload = [], int $status = ResponseStatus::SUCCESS->value): JsonResponse
    {
        $response = $this->makeResponse($message, $payload);

        // Send the final Response
        return response()->json($response, $status);
    }
}
