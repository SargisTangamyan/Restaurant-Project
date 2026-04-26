<?php

namespace App\Http\Controllers;

use App\Contracts\ResponseStrategy;
use App\Enums\ResponseStatus;
use App\Http\Requests\DishStoreRequest;
use App\Http\Requests\DishUpdateRequest;
use App\Http\Resources\DishCollection;
use App\Http\Resources\DishResource;
use App\Models\Dish;
use App\Services\ImageService;
use Illuminate\Http\Request;

class DishController extends Controller
{
    public function __construct(ResponseStrategy $responder)
    {
        parent::__construct($responder);
        // Resource authorisation injecting
        $this->authorizeResource(Dish::class, 'dish');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'price',
            'min_price',
            'max_price',
            'search',
            'sort_by',
            'sort_direction',
            'limit',
            'restaurant_id',
            'is_available',
        ]);

        if ($request->ingredients) {
            $filters['ingredients'] = explode(',', $request->ingredients);
        }
        if ($request->categories) {
            $filters['categories'] = explode(',', $request->categories);
        }

        $perPage = 10;
        if ($request->limit)
        {
            $perPage = $request->limit;
        }

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

    public function search(Request $request)
    {
        $search = trim($request->get('search', ''));

        if (empty($search)) {
            return $this->responder->send(
                'No search query provided.',
                ['names' => []],
                status: ResponseStatus::BAD_REQUEST->value,
            );
        }

        $names = Dish::hasPattern($search)->pluck('name')->toArray();

        if (empty($names)) {
            return $this->responder->send(
                'No search results found.',
                ['names' => []],
                status: ResponseStatus::BAD_REQUEST->value,

            );
        }

        return $this->responder->send(
            'Found dishes successfully.',
            ['names' => $names],
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(DishStoreRequest $request, ImageService $imageService)
    {
        $imagePaths = null;

        if ($request->hasFile('image')) {
            $imagePaths = $imageService->saveImage($request->file('image'));
        }

        $dish = Dish::create([
            'restaurant_id' => $request->restaurant_id,
            'category_id'   => $request->category_id,
            'slug'          => $request->slug,
            'name'          => $request->name,
            'description'   => $request->description,
            'price'         => $request->price,
            'image'         => $imagePaths['original'],
            'thumbnail'     => $imagePaths['thumbnail'],
            'is_available'  => $request->boolean('is_available', true),
        ]);

        if ($request->has('ingredients')) {
            $ingredients = collect($request->input('ingredients'))
                ->mapWithKeys(fn($item) => [$item['id'] => ['quantity' => $item['quantity']]]);
            $dish->ingredients()->attach($ingredients);
        }

        return new DishResource($dish->load(['category', 'ingredients']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Dish $dish)
    {
        $dish->loadMissing('ingredients');
        $allergyIds = auth()->check()
            ? auth()->user()->allergyIngredients()->pluck('ingredients.id')->toArray()
            : [];

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

        return (DishResource::make($dish))->withIngredients();
    }

    public function related(Dish $dish, Request $request)
    {
        $limit = $request->query('limit', 5);

        $relatedDishes = Dish::where('category_id', $dish->category_id)
            ->where('id', '!=', $dish->id)
            ->latest()
            ->limit($limit)
            ->get();

        return $this->responder->send(
            'Related dishes fetched successfully',
            [
                'dishes' => new DishCollection($relatedDishes),
                'count' => $relatedDishes->count(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DishUpdateRequest $request, Dish $dish)
    {
        $dish->update($request->only([
            'restaurant_id',
            'category_id',
            'slug',
            'name',
            'description',
            'price',
            'image',
            'is_available',
        ]));

        if ($request->has('ingredients')) {
            $ingredients = collect($request->input('ingredients'))
                ->mapWithKeys(fn($item) => [$item['id'] => ['quantity' => $item['quantity']]]);
            $dish->ingredients()->sync($ingredients);
        }

        return $this->responder->send(
            'Dish updated successfully',
            ['dish' => new DishResource($dish->load(['category', 'ingredients']))],
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();
        return $this->responder->send('Dish deleted successfully');
    }
}
