<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cours', function (Blueprint $table) {
            $table->id('id_cours');
            $table->string('nom_cours');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('id_matiere');
            $table->foreign('id_matiere')->references('id_matiere')->on('matieres')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cours');
    }
};
