<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Helpers\Exceptions\EnumHelperException;
use App\Helpers\Interfaces\EnumHelperInterface;
use App\Models\Agency;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * @throws EnumHelperException
     */
    public function definition(): array
    {
        /* @var $helper \App\Helpers\EnumHelper */
        $helper = resolve(EnumHelperInterface::class);

        $flag = $this->faker->boolean;

        return [
            OrderColumn::AgencyId->value => Agency::factory(),
            OrderColumn::Status->value => $this->faker->randomElement($helper->getValues(OrderStatusEnum::class)),
            OrderColumn::IsChecked->value => $flag,
            OrderColumn::IsConfirmed->value => $flag,
            OrderColumn::RentalDate->value => now()->addDays(mt_rand(1, 7)),
            OrderColumn::GuestsCount->value => 3,
            OrderColumn::TransportCount->value => 3,
            OrderColumn::UserName->value => $this->faker->unique()->name,
            OrderColumn::Email->value => $this->faker->unique()->safeEmail,
            OrderColumn::Phone->value => $this->faker->unique()->numerify('7##########'),
            OrderColumn::Note->value => $this->faker->boolean ? $this->faker->realText() : null,
            OrderColumn::AdminNote->value => $this->faker->boolean ? $this->faker->realText() : null,
            OrderColumn::ConfirmedAt->value => $flag ? now() : null,
        ];
    }
}
