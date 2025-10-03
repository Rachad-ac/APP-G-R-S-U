<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('salles', function (Blueprint $table) {
            $table->id('id_salle'); // id de la salle
            $table->string('nom')->unique(); // nom 
            $table->enum('type_salle', ['TP', 'Amphi', 'Cours']); // type de salle
            $table->integer('capacite'); // capacité maximale
            $table->string('localisation'); // localisation
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salles');
    }
};
