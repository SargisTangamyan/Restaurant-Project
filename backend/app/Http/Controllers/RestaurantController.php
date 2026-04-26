<?php

namespace App\Http\Controllers;

use App\Http\Resources\DishCollection;
use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(): JsonResponse
    {
        $restaurants = Restaurant::query()->latest()->get();

        return $this->responder->send('All the restaurants', ['data' => $restaurants]);
    }

    public function show(Restaurant $restaurant): JsonResponse
    {
        return $this->responder->send('Restaurant details', ['data' => $restaurant]);
    }

    public function dishes(Restaurant $restaurant, Request $request): DishCollection
    {
        $filters = $request->only([
            'price', 'min_price', 'max_price',
            'search', 'sort_by', 'sort_direction',
            'limit', 'is_available',
        ]);

        $filters['restaurant_id'] = $restaurant->id;

        if ($request->ingredients) {
            $filters['ingredients'] = explode(',', $request->ingredients);
        }
        if ($request->categories) {
            $filters['categories'] = explode(',', $request->categories);
        }

        $perPage = $request->limit ?? 10;

        $allergyIds = auth()->check()
            ? auth()->user()->allergyIngredients()->pluck('ingredients.id')->toArray()
            : [];

        $dishes = Dish::with('ingredients')->filter($filters)->paginate($perPage);

        $dishes->each(function ($dish) use ($allergyIds) {
            $total   = $dish->ingredients->count();
            $matches = $dish->ingredients->whereIn('id', $allergyIds)->count();

            $dish->allergy_status = match (true) {
                $matches === 0 => 'safe',
                $matches === 1 => 'modify',
                default        => 'avoid',
            };
            $dish->match_score = $total > 0
                ? (int) round((($total - $matches) / $total) * 100)
                : 100;
        });

        return new DishCollection($dishes);
    }
}