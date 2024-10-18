<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',  // Add the role field here
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationship: A user can organize multiple events (if they are an organizer).
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    /**
     * Check if the user is an organizer.
     *
     * @return bool
     */
    public function isOrganizer()
    {
        return $this->role === 'organizer';
    }

    /**
     * Check if the user is a participant.
     *
     * @return bool
     */
    public function isParticipant()
    {
        return $this->role === 'participant';
    }
}
