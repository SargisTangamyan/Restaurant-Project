<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SearchEngineService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.search_engine.url'), '/');
    }

    /**
     * Query the C++ autocomplete engine.
     * Returns an array of ['id' => int, 'word' => string, 'score' => int].
     * Returns [] when the engine is unreachable so callers can fall back gracefully.
     */
    public function search(string $prefix, int $top = 10): array
    {
        $prefix = trim($prefix);
        if ($prefix === '') {
            return [];
        }

        try {
            $response = Http::timeout(2)->get("{$this->baseUrl}/search", [
                'prefix' => $prefix,
                'top'    => $top,
            ]);

            if ($response->successful()) {
                return $response->json('results', []);
            }
        } catch (\Exception $e) {
            Log::warning('[SearchEngine] Unreachable: ' . $e->getMessage());
        }

        return [];
    }
}