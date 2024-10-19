<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quality_scores', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('awareness_entry_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->integer('score');

            $table->foreign('awareness_entry_id')->references('id')->on('awareness_entry')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_scores');
    }
};
