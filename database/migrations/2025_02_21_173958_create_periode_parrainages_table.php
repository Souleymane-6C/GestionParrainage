<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodeParrainagesTable extends Migration
{
    public function up()
    {
        Schema::create('periode_parrainages', function (Blueprint $table) {
            $table->id();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('etat')->default(false); // false = fermé, true = ouvert
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('periode_parrainages');
    }
}
