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
        return $this->hasMany(BookLocation::class,'book_id','id');
    }

    public function subjects()
    {
        return $this->hasManyThrough(Subject::class,BookSubject::class,'book_id','id');
    }
}
