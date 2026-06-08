<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Loan;
use DomainException;

class LoanService
{
    public function create(array $data): Loan
    {
        $book = Book::findOrFail($data['book_id']);
        if ($book->available_stock <= 0) {
            throw new DomainException('No hay stock disponible');
        }

        $activeLoans = Loan::where('user_id', $data['user_id'])
            ->where('status', 0)
            ->count();

        if ($activeLoans >= 3) {
            throw new DomainException('El usuario alcanzó el límite de préstamos: (3)');
        }

        return Loan::create($data);
    }
}
