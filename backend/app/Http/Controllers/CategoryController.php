<?php

namespace App\Http\Controllers;

use App\Contracts\ResponseStrategy;
use App\Enums\ResponseStatus;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function __construct(ResponseStrategy $responder)
    {
        parent::__construct($responder);
        // Resource authorisation injecting
        $this->authorizeResource(Category::class, 'dish');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // The needed page is taken based on the query of the url
        $categories = Category::paginate(10);
        return $this->responder->send(
            'The all dish list.',
            ['categories' => $categories],
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Category::create(['name' => $request->name]);

        return $this->responder->send(
            'The new dish successfully created.',
            status: ResponseStatus::CREATED->value,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->responder->send(
            'The dish',
            ['dish' => new CategoryResource($category)],
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update(['name' => $request->name]);
        return $this->responder->send(
            'Category updated successfully.',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->responder->send('Category deleted successfully.');
    }
}
