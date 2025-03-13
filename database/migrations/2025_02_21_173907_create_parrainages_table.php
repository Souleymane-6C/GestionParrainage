<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('parrainages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('electeur_id')->constrained('electeurs')->onDelete('cascade');
            $table->foreignId('candidat_id')->constrained('candidats')->onDelete('cascade');
            $table->string('code_validation')->nullable(); // Code de validation envoyé par mail/SMS
            $table->boolean('valide')->default(false); // Indique si le parrainage est confirmé
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parrainages');
    }
};
