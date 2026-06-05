<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    Use HasFactory;
    
    protected $guarded = [];
    protected $fillable = [
        'title', 
        'isbn', 
        'publication_year', 
        'pages', 
        'description', 
        'available_stock'
    ];

    public function authors() {
        return $this->belongsToMany(Author::class, 'author_books');
    }

    public function scopeAvailable(Builder $query) {
        return $query->where('available_stock', '>', 0);
    }
    
    public function scopePublishedInYear(Builder $query, $year) {
        return $query->where('publication_year', $year);
    }

    public function scopeByAuthor(Builder $query, int $authorId) {
        return $query->whereHas('authors', function($q) use ($authorId) {
            $q->where('authors.id', $authorId);
        });
    }
}