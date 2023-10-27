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
        Schema::disableForeignKeyConstraints();

        Schema::create('abs_jstf_sancs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('absence_id');
            $table->foreign('absence_id')->references('id')->on('absence');

            $table->unsignedBigInteger('justification_id');
            $table->foreign('justification_id')->references('id')->on('justification');

            $table->unsignedBigInteger('sanction_id')->nullable();
            $table->foreign('sanction_id')->references('id')->on('nature_sanction');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abs_jstf_sancs');
    }
};
