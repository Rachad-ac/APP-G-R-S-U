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
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('salle_id')->constrained('salles')->onDelete('cascade');
        $table->dateTime('date_debut')->index();
        $table->dateTime('date_fin')->index();
        $table->enum('statut', ['en_attente','confirmee','annulee'])->default('en_attente')->index();
        $table->text('motif')->nullable();
        $table->timestamps();
        $table->softDeletes();

        $table->index(['salle_id', 'date_debut', 'date_fin']);
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
