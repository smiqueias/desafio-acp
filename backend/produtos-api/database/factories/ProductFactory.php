<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat('2','0.00','100000.00'),
            'code' => $this->faker->uuid,
            'category' => $this->faker->randomElement([
                "Categoria 1",
                "Categoria 2",
                "Categoria 3"
            ]),
            'status' => $this->faker->randomElement([
                "Sem Estoque",
                "Em Estoque",
            ]),
        ];
    }
}
