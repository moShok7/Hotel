<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'title',
        'description',
        'poster_url',
        'floor_area',
        'type',
        'price',
        'hotel_id',
    ];

    public function hotel(){
        return $this->belongsTo(hotel::class);
    }
    public function facilities(){
        return $this->belongsToMany(Facility::class);
    }
 public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
