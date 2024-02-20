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
        Schema::create('api_error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('response_code');
            $table->text('response_message');
            $table->string('exception_code');
            $table->text('exception_message');
            $table->text('query_parameters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_error_logs');
    }
};
