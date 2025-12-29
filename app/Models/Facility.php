<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'title',
    ];
    public function Hotels(){
        return $this->belongsToMany(hotel::class);
    }
     public function rooms(){
        return $this->belongsToMany(hotel::class);
    }
    
}
