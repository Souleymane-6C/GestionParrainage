<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('electeurs_temp', function (Blueprint $table) {
            $table->id();
            $table->string('numero_carte_electeur')->unique();
            $table->string('numero_cin')->unique();
            $table->string('nom_famille');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->enum('sexe', ['H', 'F']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('electeurs_temp');
    }
};
