<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Enums\ResponseStatus;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $role='user'): Model
    {
        return User::factory()->create(['role' => $role]);
    }

    private function createCategory(string $name, Model $user)
    {
        $this->actingAs($user);

        return $this->postJson(route('categories.store'), ['name' => $name]);
    }

    private function updateCategory(int $id, string $newName, Model $user){
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
        $response = $this->getJson(route('categories.show', 100));
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

        $this->assertDatabaseMissing('categories', [
            'id' => $id,
        ]);
    }
}
