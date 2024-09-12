<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function collaborations()
    {
        return $this->hasMany(Collaboration::class);
    }

    public function tasks()
    {
        return $this->hasMany(Tache::class, 'assigné_a');
    }

    public function contents()
    {
        return $this->hasMany(Contenu::class, 'uploadé_par');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'expéditeur_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
