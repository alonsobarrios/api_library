<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanRequest;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['book', 'user'])->paginate(10);
        return response()->json($loans);
    }

    public function store(StoreLoanRequest $request)
    {
        $loan = Loan::create($request->validated());
        return response()->json($loan->load(['book', 'user']), 201);
    }

    public function returnLoan(Loan $loan)
    {
        $loan->update(['returned' => true]);
        return response()->json($loan->load(['book', 'user']));
    }
}
