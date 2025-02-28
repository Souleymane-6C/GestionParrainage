<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParrainagesTable extends Migration
{
    public function up()
    {
        Schema::create('parrainages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('electeur_id')->constrained(); // Clé étrangère vers Electeur
            $table->foreignId('candidat_id')->constrained(); // Clé étrangère vers Candidat
            $table->timestamp('date_parrainage');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parrainages');
    }
}
