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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('id_reservation');
            $table->unsignedBigInteger('id_utilisateur'); // FK vers utilisateur
            $table->unsignedBigInteger('id_salle');       // FK vers salle
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->enum('statut', ['En attente', 'Confirmée', 'Annulée'])->default('En attente');
            $table->timestamps();

            // Clés étrangères
            $table->foreign('id_utilisateur')
                ->references('id_utilisateur')
                ->on('utilisateurs')
                ->onDelete('cascade');

            $table->foreign('id_salle')
                ->references('id_salle')
                ->on('salles')
                ->onDelete('cascade');
        });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
