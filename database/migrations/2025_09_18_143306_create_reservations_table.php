<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            /*
             $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('salle_id')->constrained('salles')->onDelete('cascade');
            */

            // Pour tester sans dépendance :
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('salle_id')->nullable();

            // Dates de réservation
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');

            // Informations complémentaires
            $table->string('motif')->nullable();

            // Statut de la réservation
            $table->enum('statut', ['en_attente', 'confirmee', 'annulee'])
                  ->default('en_attente');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
