<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    // Définir la table associée au modèle
    protected $table = 'notifications';

    // Les attributs qui sont mass assignable
    protected $fillable = [
        'utilisateur_id',
        'projet_id',
        'contenu',
        'lu',
    ];

    // Les attributs qui doivent être castés en types natifs
    protected $casts = [
        'lu' => 'boolean',
    ];

    /**
     * Relation avec le modèle User pour l'utilisateur qui reçoit la notification
     *
     * @return BelongsTo
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    /**
     * Relation avec le modèle Projet pour le projet associé à la notification (si applicable)
     *
     * @return BelongsTo|null
     */
    public function projet(): ?BelongsTo
    {
        return $this->projet_id ? $this->belongsTo(Projet::class, 'projet_id') : null;
    }
}

