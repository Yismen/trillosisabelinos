<?php

use App\Models\Plan;
use App\Models\Registration;
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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Plan::class);
            $table->foreignIdFor(Registration::class);
            $table->integer('count')->unsigned()->default(0);
            $table->integer('unit_price')->unsigned()->default(0);
            $table->integer('amount')->unsigned()->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
