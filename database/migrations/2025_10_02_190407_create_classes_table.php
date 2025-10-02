<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id('id_classe');
            $table->string('nom');
            $table->unsignedBigInteger('id_filiere');
            $table->string('niveau');
            $table->timestamps();

            // clé étrangère vers filières
            $table->foreign('id_filiere')->references('id_filiere')->on('filieres')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
