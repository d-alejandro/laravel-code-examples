<?php

use App\Enums\OrderStatusEnum;
use App\Helpers\Interfaces\EnumHelperInterface;
use App\Models\Agency;
use App\Models\Enums\OrderColumn;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const AUTO_INCREMENT_ID_START = 10000001;

    public function up(): void
    {
        /* @var $helper \App\Helpers\EnumHelper */
        $helper = resolve(EnumHelperInterface::class);

        Schema::create(Order::TABLE_NAME, function (Blueprint $table) use ($helper) {
            $table->id()->from(self::AUTO_INCREMENT_ID_START);
            $table->foreignId(OrderColumn::AgencyId->value)
                ->constrained(Agency::TABLE_NAME)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum(
                OrderColumn::Status->value,
                $helper->getValues(OrderStatusEnum::class)
            )
                ->default(OrderStatusEnum::Waiting->value);
            $table->boolean(OrderColumn::IsChecked->value)->default(false);
            $table->boolean(OrderColumn::IsConfirmed->value)->default(false);
            $table->timestamp(OrderColumn::RentalDate->value)->nullable();
            $table->integer(OrderColumn::GuestsCount->value);
            $table->integer(OrderColumn::TransportCount->value);
            $table->string(OrderColumn::UserName->value)->nullable();
            $table->string(OrderColumn::Email->value);
            $table->string(OrderColumn::Phone->value);
            $table->text(OrderColumn::Note->value)->nullable();
            $table->text(OrderColumn::AdminNote->value)->nullable();
            $table->timestamp(OrderColumn::ConfirmedAt->value)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(Order::TABLE_NAME);
    }
};
