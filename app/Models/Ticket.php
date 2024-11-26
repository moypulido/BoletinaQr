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

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'ticket_promotion');
    }

    public function markAsUsed()
    {
        $this->is_used = true;
        $this->save();
    }

    public function getStatusTiket()
    {
        return $this->is_used ? 'Used' : 'Unused';
    }
}
