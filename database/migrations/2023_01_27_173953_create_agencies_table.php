<?php

use App\Models\Agency;
use App\Models\Enums\AgencyColumn;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(Agency::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(AgencyColumn::Name->value)->unique();
            $table->text(AgencyColumn::Contact->value)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(Agency::TABLE_NAME);
    }
};
