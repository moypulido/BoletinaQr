<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'ticket_code',
        'is_used',
        'qr_code',
        'email',
        'name',
        'phone',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
