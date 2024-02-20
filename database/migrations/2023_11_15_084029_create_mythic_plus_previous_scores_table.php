<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mythic_plus_previous_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained();
            $table->string('season');
            $table->double('overall');
            $table->string('overall_color');
            $table->double('tank');
            $table->string('tank_color');
            $table->double('healer');
            $table->string('healer_color');
            $table->double('dps');
            $table->string('dps_color');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mythic_plus_previous_scores');
    }
};
