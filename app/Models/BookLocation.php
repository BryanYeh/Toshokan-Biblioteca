<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'book_id',
        'location_id',
        'barcode',
        'location'
    ];

    public function library()
    {
        return $this->belongsTo(Location::class,'location_id','id');
    }
}
