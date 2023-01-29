<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\Enums\AgencyColumn;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgencyFactory extends Factory
{
    protected $model = Agency::class;

    public function definition(): array
    {
        return [
            AgencyColumn::Name->value => $this->faker->unique()->company,
            AgencyColumn::Contact->value => $this->faker->unique()->address,
        ];
    }
}
