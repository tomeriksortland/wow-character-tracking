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
        Schema::create('mythic_plus_highest_level_runs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('character_id')->index();
            $table->string('dungeon');
            $table->string('key_level');
            $table->string('completion_time');
            $table->string('dungeon_total_time');
            $table->string('affix_one');
            $table->string('affix_one_icon');
            $table->string('affix_two');
            $table->string('affix_two_icon');
            $table->string('affix_three');
            $table->string('affix_three_icon');
            $table->string('seasonal_affix')->nullable();
            $table->string('seasonal_affix_icon')->nullable();
            $table->string('run_id');
            $table->string('run_url');
            $table->timestamp('completed_at');
            $table->timestamps();

            $table->foreign('character_id')->references('id')->on('characters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mythic_plus_highest_level_runs');
    }
};
