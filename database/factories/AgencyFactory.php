<?php

namespace Database\Factories;

use App\Models\Agency;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgencyFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Agency::class;

    public function definition(): array
    {
        return [
            Agency::COLUMN_NAME => $this->faker->unique()->company,
            Agency::COLUMN_CONTACT => $this->faker->unique()->address,
        ];
    }
}
