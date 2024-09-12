<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('projet_id')->nullable()->constrained('projets')->onDelete('cascade');
            $table->string('contenu');
            $table->boolean('lu')->default(false);
            $table->timestamps(); // `created_at` et `updated_at` pour suivre les dates
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
