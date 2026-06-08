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
        'birth_date' => 'date:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function books() {
        return $this->belongsToMany(Book::class, 'author_books');
    }

}
