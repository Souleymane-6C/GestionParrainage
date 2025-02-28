<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriqueUploadsTable extends Migration
{
    public function up()
    {
        Schema::create('historique_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // référence à l'utilisateur
            $table->string('ip_address');
            $table->string('file_hash'); // Empreinte SHA256 du fichier
            $table->timestamp('date_upload');
            $table->enum('status', ['success', 'error']);
            $table->text('error_message')->nullable(); // Message d'erreur si échec
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historique_uploads');
    }
}
