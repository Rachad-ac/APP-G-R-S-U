<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('matieres', function (Blueprint $table) {
            $table->id('id_matiere'); // clé primaire
            $table->string('nom');
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('matieres');
    }
};
