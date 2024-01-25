<?php

namespace Database\Factories;

use App\Models\Pets;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetsFactory extends Factory
{
    protected $model = Pets::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'status' => $this->faker->randomElement(['wyleczony', 'leczenie']),
            'category_id' => function () {
                return Categories::factory()->create()->id;
            },
        ];
    }
}
