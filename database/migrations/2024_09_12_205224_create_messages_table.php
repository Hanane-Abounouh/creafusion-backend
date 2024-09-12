<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('contenu');
            $table->foreignId('auteur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('destinataire_id')->constrained('users')->onDelete('cascade');
            $table->date('date_envoi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}

