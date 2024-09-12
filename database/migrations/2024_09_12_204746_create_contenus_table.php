<?php
// database/migrations/xxxx_xx_xx_create_contenus_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenusTable extends Migration
{
    public function up()
    {
        Schema::create('contenus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained('projets')->onDelete('cascade');
            $table->string('nom_fichier');
            $table->string('chemin_fichier');
            $table->foreignId('uploadé_par')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contenus');
    }
}
