<?php
// database/migrations/xxxx_xx_xx_create_projets_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetsTable extends Migration
{
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description');
            $table->foreignId('proprietaire_id')->constrained('users')->onDelete('cascade');
            $table->enum('statut', ['En cours', 'Terminé', 'Annulé']);
            $table->date('date_limite');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projets');
    }
}
