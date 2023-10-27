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
        Schema::create('archive_stagaire', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('genre');
            $table->string('email')->unique();
            $table->string('tele')->unique();
            $table->string('cin')->unique();
            $table->string('adresse');
            $table->date('dateNaissance');
            $table->year('dateInscription');
            $table->string('photo')->nullable();
            $table->decimal('noteComportement', 2, 1);
            $table->decimal('noteAssiduite', 4, 2);
            $table->year('anneeBac')->nullable();
            $table->decimal('moyenBac', 4, 2)->nullable();
            $table->text('mentionBac')->nullable();
            $table->text('autreDiplome')->nullable();

            $table->unsignedBigInteger('Section_id');
            $table->foreign('Section_id')->references('id')->on('section');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_stagaire');
    }
};
