<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElecteursTable extends Migration
{
    public function up()
    {
        Schema::create('electeurs', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cin')->unique();
            $table->string('numero_electeur')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->enum('sexe', ['M', 'F']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('electeurs');
    }
}
