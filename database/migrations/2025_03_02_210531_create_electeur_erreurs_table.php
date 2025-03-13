<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('electeurs_erreurs', function (Blueprint $table) {
            $table->id();
            $table->string('numero_carte_electeur')->nullable();
            $table->string('numero_cni')->nullable();
            $table->string('nom_famille')->nullable();
            $table->string('bureau_vote')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('code_authentification')->nullable(); // Code envoyé par mail/SMS
            $table->string('nature_erreur'); // Type d'erreur détectée
            $table->text('description_erreur'); // Détails sur l'erreur
            $table->foreignId('tentative_upload_id')->constrained('historique_uploads')->onDelete('cascade'); // Référence à l'historique
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('electeurs_erreurs');
    }
};
