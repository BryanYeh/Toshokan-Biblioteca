<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public function books()
    {
        // return $this->hasMany(BookLocation::class,'book_id','id');
        // return $this->hasManyThrough(Location::class, BookLocation::class,'book_id','id');
        return $this->belongsToMany(Books::class);
    }

    public function copies()
    {
        return $this->hasMany(BookLocation::class);
    }
}
