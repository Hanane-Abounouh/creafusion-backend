<?php

// app/Models/Contenu.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{
    protected $fillable = [
        'projet_id',
        'nom_fichier',
        'chemin_fichier',
        'uploadé_par',
    ];

    public function project()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploadé_par');
    }
}

