<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookSubject extends Model
{
    use HasFactory;

    protected $table = 'book_subject';

    protected $fillable = [
        'book_id',
        'subject_id'
    ];
}
