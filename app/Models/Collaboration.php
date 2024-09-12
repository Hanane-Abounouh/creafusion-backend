<?php

// app/Models/Collaboration.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collaboration extends Model
{
    protected $fillable = [
        'projet_id',
        'utilisateur_id',
        'role_dans_projet',
    ];

    public function project()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }
}

