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
        Schema::create('absence', function (Blueprint $table) {
            $table->id();
            $table->char('type'); //abs or rtd cause they'll be an instances that are accumulation of absence
            $table->integer('seance');
            $table->char('typeSeance');
            $table->date('dateAbs');
            $table->date('dateJsf')->nullable();
            $table->integer('nbJoursJsf')->nullable();
            $table->decimal('noteReduit', 2, 2)->nullable();

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
        Schema::dropIfExists('absence');
    }
};
