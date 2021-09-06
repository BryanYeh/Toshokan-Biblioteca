<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lend extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'lend_date',
        'returned_date',
        'late_fee_paid',
        'damaged_fee_paid',
        'notes'
    ];

    public function patron()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function copy()
    {
        return $this->belongsTo(BookLocation::class,'book_id','id');
    }

    public function book()
    {
        return $this->belongsTo(Books::class);
    }
}
