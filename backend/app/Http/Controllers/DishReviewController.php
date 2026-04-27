<?php

namespace App\Http\Controllers;

use App\Enums\ResponseStatus;
use App\Http\Requests\DishReviewStoreRequest;
use App\Http\Requests\DishReviewUpdateRequest;
use App\Http\Resources\DishReviewResource;
use App\Models\Dish;
use App\Models\DishReview;

class DishReviewController extends Controller
{
    public function index(Dish $dish)
    {
        $reviews = $dish->reviews()
            ->with('user')
            ->latest()
            ->paginate(10);

        return $this->responder->send(
            'Reviews fetched successfully',
            [
                'reviews' => DishReviewResource::collection($reviews),
                'meta'    => [
                    'total'        => $reviews->total(),
                    'current_page' => $reviews->currentPage(),
                    'last_page'    => $reviews->lastPage(),
                    'per_page'     => $reviews->perPage(),
                ],
            ]
        );
    }

    public function store(DishReviewStoreRequest $request, Dish $dish)
    {
        $this->authorize('create', DishReview::class);

        if ($dish->reviews()->where('user_id', auth()->id())->exists()) {
            return $this->responder->send(
                'You have already reviewed this dish',
                status: ResponseStatus::CONFLICT->value,
            );
        }

        $review = $dish->reviews()->create([
            'user_id' => auth()->id(),
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return $this->responder->send(
            'Review added successfully',
            ['review' => new DishReviewResource($review->load('user'))],
            status: ResponseStatus::CREATED->value,
        );
    }

    public function update(DishReviewUpdateRequest $request, Dish $dish, DishReview $review)
    {
        $this->authorize('update', $review);

        $review->update($request->only(['rating', 'comment']));

        return $this->responder->send(
            'Review updated successfully',
            ['review' => new DishReviewResource($review->load('user'))],
        );
    }

    public function destroy(Dish $dish, DishReview $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return $this->responder->send('Review deleted successfully');
    }
}