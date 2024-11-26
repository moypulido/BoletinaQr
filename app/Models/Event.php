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
        'event_date',
        'address',
        'price',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>', now());
    }

    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }
}
