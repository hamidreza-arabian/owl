<?php

namespace Database\Factories;

use App\Models\stock;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class stockFactory extends Factory
{
    protected $model = stock::class;

    public function definition(): array
    {
        return [
            'symbol' => $this->faker->word . Str::random(5),
            'company' => $this->faker->word . Str::random(5),
            'market' => $this->faker->randomElement(stock::$market),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function startWith($str): static
    {
        return $this->state(fn (array $attributes) => [
            'symbol' => $str.fake()->unique()->word(),
        ]);
    }
}
