<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'discount_percentage',
        'buy_quantity',
        'get_quantity',
        'fixed_price',
        'valid_from',
        'valid_until',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_promotion');
    }

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_promotion');
    }

    public function setTypeAttribute($value)
    {
        $allowedTypes = ['buy_x_get_y', 'fixed_price', 'discount_percentage'];
        if (!in_array($value, $allowedTypes)) {
            throw new \InvalidArgumentException("Invalid promotion type: $value");
        }
        $this->attributes['type'] = $value;
    }
    public function isActive()
    {
        $now = now();
        return $now->between($this->valid_from, $this->valid_until);
    }

}
