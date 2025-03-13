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
            $table->string('ip_address')->nullable()->default('127.0.0.1');
            $table->string('file_hash')->nullable()->default(''); // Empreinte SHA256 du fichier
            $table->timestamp('date_upload');
            $table->enum('status', ['success', 'error', 'pending'])->default('pending');
            $table->text('error_message')->nullable(); // Message d'erreur si échec
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historique_uploads');
    }
}
