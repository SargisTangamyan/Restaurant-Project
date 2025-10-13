<?php

namespace App\Http\Controllers;

use App\Contracts\ResponseStrategy;
use App\Enums\ResponseStatus;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class CategoryController extends Controller
{
    public function __construct(ResponseStrategy $responder)
    {
        parent::__construct($responder);
        $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Return full tree if ?tree=true
        if ($request->boolean('tree')) {
            $categories = Category::whereNull('parent_id')
                ->with('childrenRecursive')
                ->get();

            return $this->responder->send(
                'Full category tree.',
                ['categories' => CategoryResource::collection($categories)]
            );
        }

        // Paginated flat list
        $categories = Category::paginate($request->per_page ?? 10);

        return $this->responder->send(
            'All categories list.',
            [
                'categories' => CategoryResource::collection($categories),
                'pagination' => [
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                    'per_page' => $categories->perPage(),
                    'total' => $categories->total(),
                ]
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->only(['name', 'parent_id']);

        $category = new Category(['name' => $data['name']]);
        $category->parent_id = $data['parent_id'];
        $category->save();

        return $this->responder->send(
            'New category created successfully.',
            [
                'categories' => new CategoryResource($category->load('childrenRecursive'))
            ],
            ResponseStatus::CREATED->value
        );
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return $this->responder->send(
                'Query Not given',
                ['error' => 'No Query given'],
                status: ResponseStatus::BAD_REQUEST->value
            );
        }

        $categories = Category::where('name', 'LIKE', "%{$query}%")->orderBy('name')->paginate($request->per_page ?? 10);

        if ($categories->isEmpty()) {
            return $this->responder->send(
                'No categories found',
                ['error' => 'No categories found'],
                status: ResponseStatus::BAD_REQUEST->value
            );
        }

        return $this->responder->send(
            'Categories found',
            ['categories' => CategoryResource::collection($categories)]
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('childrenRecursive');

        return $this->responder->send(
            'The category',
            ['category' => new CategoryResource($category)]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->only(['name', 'parent_id']);
        $category->update($data);

        return $this->responder->send(
            'Category updated successfully.',
            ['category' => new CategoryResource($category->load('childrenRecursive'))]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->children()->exists()) {
            return $this->responder->send(
                'Cannot delete category with subcategories.',
                status: ResponseStatus::UNPROCESSABLE->value
            );
        }

        $category->delete();

        return $this->responder->send(
            'Category deleted successfully.'
        );
    }
}
