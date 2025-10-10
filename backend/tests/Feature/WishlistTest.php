<?php

namespace Tests\Feature;

use App\Models\Dish;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $dish;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->dish = Dish::factory()->create();
    }

    public function test_user_can_add_product_to_wishlist()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('wishlist.store', $this->dish->id));

        $response->assertStatus(200)
            ->assertJson(['message' => 'Added to Wishlist']);

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $this->user->id,
            'dish_id' => $this->dish->id,
        ]);
    }

    public function test_user_cannot_add_same_product_twice()
    {
        $this->actingAs($this->user)
            ->postJson(route('wishlist.store', $this->dish->id));

        $response = $this->actingAs($this->user)
            ->postJson(route('wishlist.store', $this->dish->id));

        $response->assertStatus(409)
            ->assertJson(['message' => 'Already in Wishlist']);
    }

    public function test_user_can_view_his_wishlist()
    {
        $this->user->wishlist()->attach($this->dish->id);

        $response = $this->actingAs($this->user)
            ->getJson(route('wishlist.index'));

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $this->dish->id]);
    }
}
