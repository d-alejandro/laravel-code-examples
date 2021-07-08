<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            Order::COLUMN_AGENCY_ID => Agency::factory(),
            Order::COLUMN_STATUS => $this->faker->randomElement(Order::statuses()),
            Order::COLUMN_IS_CHECKED => $flag = $this->faker->boolean,
            Order::COLUMN_IS_CONFIRMED => $flag,
            Order::COLUMN_DATE_TOUR => now()->addDays(mt_rand(1, 7)),
            Order::COLUMN_GUESTS_COUNT => 3,
            Order::COLUMN_SCOOTERS_COUNT => 3,
            Order::COLUMN_TRANSFER => $this->faker->boolean ? $this->faker->realText(100) : null,
            Order::COLUMN_HOTEL => $this->faker->unique()->address,
            Order::COLUMN_ROOM_NUMBER => mt_rand(1, 100),
            Order::COLUMN_GENDER => $gender = $this->faker->randomElement([null, 'male', 'female']),
            Order::COLUMN_NAME => $this->faker->unique()->name($gender),
            Order::COLUMN_EMAIL => $this->faker->unique()->safeEmail,
            Order::COLUMN_NATIONALITY => $this->faker->randomElement([null, 'Russian', 'Englishman', 'Frenchman']),
            Order::COLUMN_PHONE => $this->faker->unique()->numerify('7##########'),
            Order::COLUMN_IS_SUBSCRIBE => $this->faker->boolean,
            Order::COLUMN_NOTE => $this->faker->boolean ? $this->faker->realText() : null,
            Order::COLUMN_ADMIN_NOTE => $this->faker->boolean ? $this->faker->realText() : null,
            Order::COLUMN_PHOTO_REPORT => $this->faker->url,
            Order::COLUMN_REFERRER => $this->faker->randomElement(
                ['google.com', 'yahoo.com', 'yandex.ru', 'jacobs.com']
            ),
            Order::COLUMN_CONFIRMED_AT => $flag ? now() : null,
        ];
    }
}
