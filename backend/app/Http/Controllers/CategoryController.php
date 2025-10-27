<?php

namespace App\Http\Controllers;

use App\Contracts\ResponseStrategy;
use App\Enums\ResponseStatus;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class CategoryController extends Controller
{
    public function __construct(
        ResponseStrategy $responder,
        private CategoryService $categoryService
    )
    {
        parent::__construct($responder);
        $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Return the full tree if ?tree=true
        if ($request->boolean('tree')) {
            $categories = $this->categoryService->getCategoryTree();

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
        try {
            $category = $this->categoryService->createCategory(
                $request->only(['name', 'parent_id'])
            );

            return $this->responder->send(
                'New category created successfully.',
                ['category' => new CategoryResource($category)],
                ResponseStatus::CREATED->value
            );
        } catch (\Exception $e) {
            return $this->responder->send(
                $e->getMessage(),
                status: ResponseStatus::UNPROCESSABLE->value
            );
        }
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

        $categories = $this->categoryService->searchCategories(
            $query,
            $request->per_page ?? 10
        );

        if ($categories->isEmpty()) {
            return $this->responder->send(
                'No categories found',
                ['categories' => []],
            );
        }

        return $this->responder->send(
            'Categories found',
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
        try {
            $category = $this->categoryService->updateCategory(
                $category,
                $request->only(['name', 'parent_id'])
            );

            return $this->responder->send(
                'Category updated successfully.',
                ['category' => new CategoryResource($category)]
            );
        } catch (\Exception $e) {
            return $this->responder->send(
                $e->getMessage(),
                status: ResponseStatus::UNPROCESSABLE->value
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $this->categoryService->deleteCategory($category);

            return $this->responder->send(
                'Category deleted successfully.'
            );
        } catch (\Exception $e) {
            return $this->responder->send(
                $e->getMessage(),
                status: ResponseStatus::UNPROCESSABLE->value
            );
        }
    }
}
