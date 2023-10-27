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
        Schema::create('module', function (Blueprint $table) {
            $table->id();
            $table->string('libelleModule');
            $table->integer('MH_total');
            $table->integer('MH_Presentiel')->nullable();
            $table->integer('MH_Distentiel')->nullable();
            $table->text('semestre');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module');
    }
};
