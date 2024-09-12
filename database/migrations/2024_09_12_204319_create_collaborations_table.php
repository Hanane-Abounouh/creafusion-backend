<?php
// database/migrations/xxxx_xx_xx_create_collaborations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollaborationsTable extends Migration
{
    public function up()
    {
        Schema::create('collaborations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained('projets')->onDelete('cascade');
            $table->foreignId('utilisateur_id')->constrained('users')->onDelete('cascade');
            $table->string('role_dans_projet');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collaborations');
    }
}
