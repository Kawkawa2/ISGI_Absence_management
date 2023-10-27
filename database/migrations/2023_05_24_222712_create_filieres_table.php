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
        Schema::create('filiere', function (Blueprint $table) {
            $table->id();
            $table->string('codeFiliere');
            $table->string('nomFiliere');
            $table->string('option');
            $table->string('typeFormation');
            $table->string('niveau');
            $table->string('duree');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filiere');
    }
};
