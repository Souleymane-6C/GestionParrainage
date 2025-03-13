<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('parrains', function (Blueprint $table) {
            $table->id();
            $table->string('numero_carte')->unique();
            $table->string('numero_cni')->unique();
            $table->string('nom');
            $table->string('bureau_de_vote');
            $table->string('email')->unique();
            $table->string('telephone')->unique();
            $table->string('code_authentification')->nullable();
            $table->string('code_verification')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parrains');
    }
};
