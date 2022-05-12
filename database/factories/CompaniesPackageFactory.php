<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Packages>
 */
class CompaniesPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company' => $this->faker->name . ' Package',
            'day' => rand(30, 365),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
