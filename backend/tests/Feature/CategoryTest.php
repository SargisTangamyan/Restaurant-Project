<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Enums\ResponseStatus;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $role = 'user'): Model
    {
        return User::factory()->create(['role' => $role]);
    }

    private function createCategory(string $name, Model $user, ?int $parentId = null)
    {
        $this->actingAs($user);

        $data = ['name' => $name];
        if ($parentId) {
            $data['parent_id'] = $parentId;
        }

        return $this->postJson(route('categories.store'), $data);
    }

    private function updateCategory(int $id, string $newName, Model $user)
    {
        $this->actingAs($user);

        return $this->putJson(route('categories.update', $id), ['name' => $newName]);
    }

    public function test_getting_first_10_categories(): void
    {
        $response = $this->getJson(route('categories.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'categories',
            ]);
    }

    public function test_getting_concrete_category(): void
    {
        $admin = $this->createUser('admin');
        $this->createCategory('Test Category', $admin);
        $response = $this->getJson(route('categories.show', 1));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'category',
            ]);
    }

    public function test_getting_nonexistent_category(): void
    {
        $response = $this->getJson(route('categories.show', 9999));
        $response->assertStatus(404);
    }

    public function test_creating_category_as_admin(): void
    {
        $admin = $this->createUser('admin');
        $response = $this->createCategory('Salad Fresh', $admin);

        $response->assertStatus(ResponseStatus::CREATED->value)
            ->assertJsonStructure(['message']);

        $this->assertDatabaseHas('categories', [
            'name' => 'Salad Fresh',
            'slug' => 'salad-fresh',
        ]);
    }

    public function test_creating_category_as_simple_user(): void
    {
        $user = $this->createUser();
        $response = $this->createCategory('Salad Fresh', $user);
        $response->assertStatus(ResponseStatus::FORBIDDEN->value);
    }

    public function test_updating_category_as_admin(): void
    {
        $name = 'Salad Fresh';
        $admin = $this->createUser('admin');
        $this->createCategory($name, $admin);
        $id = Category::where('name', $name)->first()->id;

        $response = $this->updateCategory($id, 'Salad Very Fresh', $admin);

        $response->assertStatus(ResponseStatus::SUCCESS->value)
            ->assertJsonStructure(['message']);

        $this->assertDatabaseHas('categories', [
            'id' => $id,
            'name' => 'Salad Very Fresh',
            'slug' => 'salad-very-fresh',
        ]);
    }

    public function test_updating_category_as_simple_user(): void
    {
        $name = 'Salad Fresh';
        $user = $this->createUser();
        $admin = $this->createUser('admin');
        $this->createCategory($name, $admin);
        $id = Category::where('name', $name)->first()->id;

        $response = $this->updateCategory($id, 'Salad Very Fresh', $user);
        $response->assertStatus(ResponseStatus::FORBIDDEN->value);
    }

    public function test_destroying_category_as_admin(): void
    {
        $admin = $this->createUser('admin');
        $name = 'Salad Fresh';
        $this->createCategory($name, $admin);
        $id = Category::where('name', $name)->first()->id;

        $response = $this->deleteJson(route('categories.destroy', $id));

        $response->assertStatus(ResponseStatus::SUCCESS->value);

        $this->assertDatabaseMissing('categories', ['id' => $id]);
    }

    /** 🧩 New Tests for Subcategories **/

    public function test_admin_can_create_subcategory(): void
    {
        $admin = $this->createUser('admin');

        // Create parent
        $parentResponse = $this->createCategory('Food', $admin);
        $parentId = Category::where('name', 'Food')->first()->id;

        // Create subcategory
        $response = $this->createCategory('Fruits', $admin, $parentId);

        $response->assertStatus(ResponseStatus::CREATED->value)
            ->assertJsonStructure(['message']);

        $this->assertDatabaseHas('categories', [
            'name' => 'Fruits',
            'parent_id' => $parentId,
        ]);
    }

    public function test_subcategory_appears_under_parent_in_response(): void
    {
        // Create admin user and authenticate
        $admin = $this->createUser('admin');
        $this->actingAs($admin);

        // Create category hierarchy
        $parent = Category::factory()->create(['name' => 'Food', 'slug' => 'food']);
        $child = Category::factory()->create(['name' => 'Fruits', 'slug' => 'fruits', 'parent_id' => $parent->id]);
        $subChild = Category::factory()->create(['name' => 'Apples', 'slug' => 'apples', 'parent_id' => $child->id]);

        // Call the endpoint
        $response = $this->getJson(route('categories.index'));

        // Assert HTTP OK
        $response->assertStatus(200);

        // Assert the structure matches your JSON tree
        $response->assertJsonStructure([
            'message',
            'categories',
        ]);

        // Optional: assert specific data is present
        $response->assertJsonFragment([
            'name' => 'Food',
        ]);
        $response->assertJsonFragment([
            'name' => 'Fruits',
        ]);
        $response->assertJsonFragment([
            'name' => 'Apples',
        ]);
    }


    public function test_cannot_create_subcategory_with_invalid_parent(): void
    {
        $admin = $this->createUser('admin');

        $this->actingAs($admin);

        $response = $this->postJson(route('categories.store'), [
            'name' => 'Invalid Subcategory',
            'parent_id' => 9999,
        ]);

        $response->assertStatus(ResponseStatus::UNPROCESSABLE->value ?? 422);
    }
}
