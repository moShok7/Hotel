<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'title',
        'description',
        'poster_url',
        'address',
    ];
    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }
    
    public function rooms(){
        return $this->hasMany(Room::class);
    }
}
