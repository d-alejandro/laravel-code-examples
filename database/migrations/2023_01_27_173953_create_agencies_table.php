<?php

use App\Models\Agency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(Agency::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(Agency::COLUMN_NAME)->unique();
            $table->text(Agency::COLUMN_CONTACT)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(Agency::TABLE_NAME);
    }
};
