<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->timestamp('dateEnvoi')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('lu')->default(false);
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_reservation')->nullable();
            $table->timestamps();

            // Relations
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_reservation')->references('id_reservation')->on('reservations')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
