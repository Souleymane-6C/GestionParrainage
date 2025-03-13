<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('electeurs', function (Blueprint $table) {
            $table->id();
            $table->string('numero_carte_electeur')->unique();
            $table->string('numero_cni')->unique();
            $table->string('nom_famille');
            $table->string('bureau_vote');
            $table->string('telephone')->unique();
            $table->string('email')->unique();
            $table->string('code_authentification')->nullable(); // Code envoyé par mail/SMS
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('electeurs');
    }
};
