<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookLocation extends Pivot
{
    use HasFactory;

    protected $table = 'book_locations';
    protected $fillable = [
        'price',
        'book_id',
        'location_id',
        'barcode',
        'location'
    ];

    public function lends()
    {
        return $this->hasMany(Lend::class, 'book_id','id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class,'location_id','id');
    }

    public function book()
    {
        return $this->belongsTo(Books::class,'book_id','id');
    }

    public function isLent()
    {
        return $this->hasMany(Lend::class, 'book_id','id')->whereNull('returned_date');
    }
}
