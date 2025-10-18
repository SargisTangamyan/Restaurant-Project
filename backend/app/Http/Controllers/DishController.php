<?php

namespace App\Http\Controllers;

use App\Contracts\ResponseStrategy;
use App\Http\Requests\DishStoreRequest;
use App\Http\Requests\DishUpdateRequest;
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
    public function index()
    {
        return DishResource::collection(Dish::paginate(10));
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
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePaths['original'],
            'thumbnail' => $imagePaths['thumbnail'],
        ]);

        if ($request->has('ingredients')) {
            $ingredients = collect($request->input('ingredients'))
                ->mapWithKeys(fn($item) => [$item['id'] => ['quantity' => $item['quantity']]]);
            $dish->ingredients()->attach($ingredients);
        }

        return $this->responder->send('message', ['path' => $imagePaths]);
        return new DishResource($dish->load(['category', 'ingredients']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Dish $dish)
    {
        return new DishResource($dish->load(['category', 'ingredients']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DishUpdateRequest $request, Dish $dish)
    {
        $dish->update($request->only(['category_id', 'name', 'description', 'price', 'image']));

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
