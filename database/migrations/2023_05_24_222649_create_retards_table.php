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
        Schema::create('retard', function (Blueprint $table) {
            $table->id();
            $table->integer('seance');
            $table->string('typeSeance');
            $table->date('dateRtd');
            

            $table->unsignedBigInteger('Stagaire_id');
            $table->foreign('Stagaire_id')->references('id')->on('stagaire');


            $table->unsignedBigInteger('Formateur_id');
            $table->foreign('Formateur_id')->references('id')->on('formateur');

            $table->unsignedBigInteger('Module_id');
            $table->foreign('Module_id')->references('id')->on('module');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retard');
    }
};
