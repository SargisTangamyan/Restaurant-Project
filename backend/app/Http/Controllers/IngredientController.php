<?php

namespace App\Http\Controllers;

use App\Contracts\ResponseStrategy;
use App\Enums\ResponseStatus;
use App\Http\Requests\IngredientStoreRequest;
use App\Http\Requests\IngredientUpdateRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{

    public function __construct(ResponseStrategy $responder)
    {
        parent::__construct($responder);
        // Resource authorisation injecting
        $this->authorizeResource(Ingredient::class, 'ingredient');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // The needed page is taken based on the query of the url
        return Ingredient::latest()->paginate($request->query('per_page') ?? 10)->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IngredientStoreRequest $request)
    {
        Ingredient::create([
            'name'  => strtolower($request->name),
            'unit'  => strtolower($request->unit),
            'price' => $request->price ?? 0, // fallback to 0 if null
        ]);

        return $this->responder->send(
            'The new ingredient successfully created.',
            status: ResponseStatus::CREATED->value,
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient)
    {
        return $this->responder->send(
            'The ingredient retrieved.',
            ['ingredient' => $ingredient->toResource()],
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IngredientUpdateRequest $request, Ingredient $ingredient)
    {
        $ingredient->update($request->only('name', 'unit', 'price'));
        return $this->responder->send(
            'Ingredient updated successfully.',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return $this->responder->send('Ingredient deleted successfully.');
    }
}
