<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('electeurs_erreurs', function (Blueprint $table) {
            $table->text('description_erreur')->default('Erreur non spécifiée')->change();
        });
    }

    public function down()
    {
        Schema::table('electeurs_erreurs', function (Blueprint $table) {
            $table->text('description_erreur')->nullable(false)->change();
        });
    }
};
