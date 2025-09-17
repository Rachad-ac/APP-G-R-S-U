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
        Schema::create('salles', function (Blueprint $table) {
            $table->id('id_salle');
            $table->string('nom_salle', 100);
            $table->integer('capacite');
            $table->string('localisation', 150);
            $table->unsignedBigInteger('id_type_salle'); // FK vers type_salle
            $table->timestamps();

            // Clé étrangère
            $table->foreign('id_type_salle')
                ->references('id_type_salle')
                ->on('type_salles')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salles');
    }
};
