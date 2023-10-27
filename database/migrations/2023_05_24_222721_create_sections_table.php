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
        Schema::create('section', function (Blueprint $table) {
            $table->id();
            $table->string('codeSection');
            $table->string('nomSection');
            $table->year('Annee');
            $table->unsignedBigInteger('Filiere_id');
            $table->foreign('Filiere_id')->references('id')->on('filiere');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section');
    }
};
