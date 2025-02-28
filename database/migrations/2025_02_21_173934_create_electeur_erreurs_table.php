<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElecteursErreursTable extends Migration
{
    public function up()
    {
        Schema::create('electeurs_erreurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('electeur_id')->constrained(); // Clé étrangère vers Electeur
            $table->foreignId('tentative_upload_id')->constrained('historique_uploads'); // Clé étrangère vers HistoriqueUpload
            $table->string('nature_erreur');
            $table->text('description_erreur');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('electeurs_erreurs');
    }
}
