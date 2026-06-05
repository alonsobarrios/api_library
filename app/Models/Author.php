<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        'first_name', 
        'last_name', 
        'birth_date', 
        'nationality',
        'biography'
    ];
    protected $casts = [
        'birth_date' => 'date',
    ];

    public function books() {
        return $this->belongsToMany(Book::class, 'author_books');
    }

}
