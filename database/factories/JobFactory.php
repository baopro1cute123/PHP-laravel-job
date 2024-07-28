<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\JobType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name,
            'user_id' => rand(1,3),
            'category_id' => rand(1,5), // Assuming you have a Category factory
            'job_type_id' => rand(1,5), // Assuming you have a JobType factory
            'vacancy' => rand(1,5),
            'location' => fake()->city,
            'description' => fake()->text,
            'experience' => rand(1,10),
            'company_name' => fake()->company,
        ];
    }
}