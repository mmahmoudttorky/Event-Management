<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'location',
        'ticket_limit',
        'organizer_id'
    ];

    // Define relation to User (organizer)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Define relation to Ticket
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
