<?php

namespace App\Services;

use App\Models\Author;
use DomainException;

class AuthorService
{
    public function delete(Author $author): void
    {
        if ($author->books()->exists()) {
            throw new DomainException('El autor tiene libros asociados');
        }

        $author->delete();
    }
}
