<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('id_reservation'); // id de la réservation
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->enum('type_reservation', ['Cours', 'Examen', 'Evenement' , 'TP']); // type de réservation
            $table->enum('statuT', ['En attente', 'Confirmee', 'Annulee'])->default('En attente');

            // Clés étrangères
            $table->unsignedBigInteger('id_user'); 
            $table->unsignedBigInteger('id_salle'); 

            $table->timestamps();

            // Définition des FK
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_salle')->references('id_salle')->on('salles')->onDelete('cascade');
        
            // $table->unsignedBigInteger('id_cours')->nullable();
            // $table->foreign('id_cours')->references('id_cours')->on('cours')->onDelete('set null');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
