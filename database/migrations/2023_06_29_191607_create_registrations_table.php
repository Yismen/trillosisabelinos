<?php

use App\Models\Event;
use App\Enums\RegistrationStatusEnum;
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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500);
            $table->foreignIdFor(Event::class);
            $table->string('phone', 15);
            $table->string('email');
            $table->string('group');
            $table->string('additional_phone')->nullable();
            $table->string('amount')->nullable();
            $table->string('amount_paid')->nullable();
            $table->string('amount_pending')->nullable();
            $table->integer('status')->default(RegistrationStatusEnum::Pending->value);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
