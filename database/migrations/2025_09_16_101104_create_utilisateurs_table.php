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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id('id_utilisateur');
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 150)->unique();
            $table->string('mot_de_passe', 255);
            $table->unsignedBigInteger('id_role');
            $table->timestamps();

            $table->foreign('id_role')
                ->references('id_role')
                ->on('roles')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
