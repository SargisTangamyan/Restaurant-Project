<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;

class RestaurantController extends Controller
{
    public function index(): JsonResponse
    {
        $restaurants = Restaurant::query()
            ->latest()
            ->get();

        return $this->responder->send(
            'All the restaurants',
            [
                'data' => $restaurants,
            ]
        );
    }
}
