<?php

// database/migrations/xxxx_xx_xx_create_taches_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTachesTable extends Migration
{
    public function up()
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained('projets')->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->enum('statut', ['À faire', 'En cours', 'Fait']);
            $table->foreignId('assigné_a')->constrained('users')->onDelete('cascade');
            $table->date('date_limite');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taches');
    }
}

