<?php

// app/Models/Tache.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    protected $fillable = [
        'projet_id',
        'titre',
        'description',
        'statut',
        'assigné_a',
        'date_limite',
    ];

    public function project()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigné_a');
    }
}

