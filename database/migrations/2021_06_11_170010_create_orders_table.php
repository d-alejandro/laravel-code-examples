<?php

use App\Models\Agency;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    private const AUTO_INCREMENT_ID_START = 10000001;

    public function up(): void
    {
        Schema::create(Order::TABLE_NAME, function (Blueprint $table) {
            $table->id()->from(self::AUTO_INCREMENT_ID_START);
            $table->unsignedBigInteger(Order::COLUMN_AGENCY_ID);
            $table->string(Order::COLUMN_STATUS)->default(Order::STATUS_WAITING);
            $table->boolean(Order::COLUMN_IS_CHECKED)->default(false);
            $table->boolean(Order::COLUMN_IS_CONFIRMED)->default(false);
            $table->timestamp(Order::COLUMN_DATE_TOUR)->nullable();
            $table->integer(Order::COLUMN_GUESTS_COUNT);
            $table->integer(Order::COLUMN_SCOOTERS_COUNT);
            $table->string(Order::COLUMN_TRANSFER)->nullable();
            $table->string(Order::COLUMN_HOTEL);
            $table->string(Order::COLUMN_ROOM_NUMBER);
            $table->string(Order::COLUMN_NAME);
            $table->string(Order::COLUMN_EMAIL);
            $table->string(Order::COLUMN_GENDER)->nullable();
            $table->string(Order::COLUMN_NATIONALITY)->nullable();
            $table->string(Order::COLUMN_PHONE);
            $table->boolean(Order::COLUMN_IS_SUBSCRIBE)->default(false);
            $table->text(Order::COLUMN_NOTE)->nullable();
            $table->text(Order::COLUMN_ADMIN_NOTE)->nullable();
            $table->string(Order::COLUMN_PHOTO_REPORT)->nullable();
            $table->string(Order::COLUMN_REFERRER)->nullable();
            $table->timestamp(Order::COLUMN_CONFIRMED_AT)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(Order::COLUMN_AGENCY_ID)->references(Agency::COLUMN_ID)->on(Agency::TABLE_NAME);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(Order::TABLE_NAME);
    }
}
