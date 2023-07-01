<?php

use App\Enums\EventStatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500);
            $table->string('slug')->nullable(); // Field name same as your `saveSlugsTo`
            $table->date('date');
            $table->integer('status')->nullable()->default(EventStatusEnum::Open->value);
            $table->longText('images');
            $table->longText('features');
            $table->string('currency')->nullable()->default('RD$');
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
