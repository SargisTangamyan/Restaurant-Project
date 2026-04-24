<?php

namespace App\Http\Controllers;

use App\Enums\ResponseStatus;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class UserAllergyController extends Controller
{
    public function index(Request $request)
    {
        $allergies = $request->user()->allergyIngredients()->get();

        return $this->responder->send(
            'User allergies retrieved.',
            ['allergies' => IngredientResource::collection($allergies)],
        );
    }

    public function store(Request $request, Ingredient $ingredient)
    {
        $user = $request->user();

        if ($user->allergyIngredients()->where('ingredient_id', $ingredient->id)->exists()) {
            return $this->responder->send(
                'Ingredient already in your allergy list.',
                status: ResponseStatus::CONFLICT->value,
            );
        }

        $user->allergyIngredients()->attach($ingredient->id);

        return $this->responder->send('Ingredient added to your allergy list.');
    }

    public function destroy(Request $request, Ingredient $ingredient)
    {
        $request->user()->allergyIngredients()->detach($ingredient->id);

        return $this->responder->send('Ingredient removed from your allergy list.');
    }
}
