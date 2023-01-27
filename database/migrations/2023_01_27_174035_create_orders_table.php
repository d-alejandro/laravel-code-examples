<?php

use App\Enums\OrderStatusEnum;
use App\Helpers\Interfaces\EnumHelperInterface;
use App\Models\Agency;
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
            $table->foreignId(Order::COLUMN_AGENCY_ID)
                ->constrained(Agency::TABLE_NAME)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum(
                Order::COLUMN_STATUS,
                $helper->getValues(OrderStatusEnum::class)
            )
                ->default(OrderStatusEnum::Waiting->value);
            $table->boolean(Order::COLUMN_IS_CHECKED)->default(false);
            $table->boolean(Order::COLUMN_IS_CONFIRMED)->default(false);
            $table->timestamp(Order::COLUMN_RENTAL_DATE)->nullable();
            $table->integer(Order::COLUMN_GUESTS_COUNT);
            $table->integer(Order::COLUMN_TRANSPORT_COUNT);
            $table->string(Order::COLUMN_USER_NAME)->nullable();
            $table->string(Order::COLUMN_EMAIL);
            $table->string(Order::COLUMN_PHONE);
            $table->text(Order::COLUMN_NOTE)->nullable();
            $table->text(Order::COLUMN_ADMIN_NOTE)->nullable();
            $table->timestamp(Order::COLUMN_CONFIRMED_AT)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(Order::TABLE_NAME);
    }
};
