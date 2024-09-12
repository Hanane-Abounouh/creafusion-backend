<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    // Spécifiez le nom de la table si elle diffère du nom par défaut
    // protected $table = 'projets'; // Décommenter si nécessaire

    // Les attributs qui sont mass assignable
    protected $fillable = [
        'nom',
        'description',
        'proprietaire_id',
        'statut',
        'date_limite',
    ];

    // Relation avec le modèle User pour le propriétaire du projet
    public function owner()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    // Relation avec le modèle Collaboration
    public function collaborations()
    {
        return $this->hasMany(Collaboration::class, 'projet_id');
    }

    // Relation avec le modèle Tache
    public function tasks()
    {
        return $this->hasMany(Tache::class, 'projet_id');
    }

    // Relation avec le modèle Fichier
    public function files()
    {
        return $this->hasMany(Fichier::class, 'projet_id');
    }

    // Relation avec le modèle Message
    public function messages()
    {
        return $this->hasMany(Message::class, 'projet_id');
    }

    // Relation avec le modèle Notification
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'projet_id');
    }
}
