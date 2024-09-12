<?php

// app/Models/Profile.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'photo',
        'lien_reseau_social',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

