<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'ticket_code',
        'qr_code',
        'email',
        'name',
        'phone',
    ];

    protected $attributes = [
        'is_used' => false,
    ];

    protected $appends = ['status'];

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

    public function getStatusAttribute()
    {
        return $this->is_used ? 'Used' : 'Unused';
    }
}