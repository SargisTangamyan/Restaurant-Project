<?php

namespace App\Http\Controllers;

use App\Contracts\ResponseStrategy;
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
        $this->authorizeResource(Category::class, 'category');
    }

    private function checkForSimilarName(string $name): bool
    {
        $slug = Category::makeSimpleSlug($name);
        $categoryWithSameSlug = Category::where('slug', $slug)->first();
        return (bool)$categoryWithSameSlug;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // The needed page is taken based on the query of the url
        $categories = Category::paginate(10);
        return $this->responder->send(
            'The all category list.',
            ['categories' => CategoryResource::collection($categories)],
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        if ($this->checkForSimilarName($request->name)) {
            throw ValidationException::withMessages([
                'name' => 'There is a category with almost same name'
            ]);
        }

        Category::create(['name' => $request->name]);

        return $this->responder->send(
            'The new category successfully created.',
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->responder->send(
            'The category',
            ['category' => new CategoryResource($category)],
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        if ($this->checkForSimilarName($request->name)) {
            throw ValidationException::withMessages([
                'name' => 'There is a category with almost same name'
            ]);
        }

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
