<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'isbn',
        'edition',
        'summary',
        'language',
        'image',
        'author',
        'publisher',
        'publication_date',
        'dewey_decimal'
    ];

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'book_locations', 'book_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class,'book_subject','book_id');
    }

    public function copies()
    {
        return $this->hasMany(BookLocation::class, 'id');
    }
}
