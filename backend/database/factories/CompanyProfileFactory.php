<?php

namespace Database\Factories;

use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CompanyProfileFactory extends Factory
{
    protected $model = CompanyProfile::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_name' => $this->faker->company(),
            'profile_image' => $this->faker->imageUrl(),
            'contact_email' => $this->faker->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
        ];
    }
}
