<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    // Définir la table associée au modèle
    protected $table = 'messages';

    // Les attributs qui sont mass assignable
    protected $fillable = [
        'contenu',
        'auteur_id',
        'destinataire_id',
        'date_envoi',
    ];

    // Les attributs qui doivent être castés en types natifs
    protected $casts = [
        'date_envoi' => 'date',
    ];

    /**
     * Relation avec le modèle User pour l'auteur du message
     *
     * @return BelongsTo
     */
    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }

    /**
     * Relation avec le modèle User pour le destinataire du message
     *
     * @return BelongsTo
     */
    public function destinataire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }
}
