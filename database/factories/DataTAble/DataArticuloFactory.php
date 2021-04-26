<?php

namespace Database\Factories\DataTAble;

use App\Models\DataTAble\DataArticulo;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataArticuloFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DataArticulo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'descripcion' => $this->faker->paragraph(),
            'stock' => $this->faker->numberBetween(1,999),
        ];
    }
}
