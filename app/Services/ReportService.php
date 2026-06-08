<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getMostBorrowedBooks()
    {
        return Book::select(
                'books.id',
                'books.title',
                DB::raw('COUNT(loans.id) as total_loans')
            )
            ->join('loans', 'books.id', '=', 'loans.book_id')
            ->groupBy('books.id', 'books.title')
            ->orderByDesc('total_loans')
            ->get();
    }

    public function getUsersWithOverdueLoans()
    {
        return User::whereHas('loans', function ($query) {
                $query->where('status', 1)
                    ->whereDate('due_date', '<', now());
            })
            ->with(['loans' => function ($query) {
                $query->where('status', 1)
                    ->whereDate('due_date', '<', now());
            }])
            ->get();
    }

    public function getBooksWithoutStock()
    {
        return Book::where('available_stock', '<=', 0)->get();
    }

    public function generate()
    {
        return [
            'most_borrowed_books' => $this->getMostBorrowedBooks(),
            'users_with_overdue_loans' => $this->getUsersWithOverdueLoans(),
            'books_without_stock' => $this->getBooksWithoutStock(),
        ];
    }
}
