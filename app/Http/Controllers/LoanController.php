<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanRequest;
use App\Models\Loan;
use App\Services\LoanService;
use Illuminate\Support\Facades\Log;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['book', 'user'])->paginate(10);
        return response()->json($loans);
    }

    public function store(StoreLoanRequest $request, LoanService $service)
    {
        try {
            $loan = $service->create($request->validated());
            return response()->json($loan->load(['book', 'user']), 201);
        } catch (\DomainException $ex) {
            return response()->json(['error' => $ex->getMessage()], 409);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json(['error' => 'Error al intertar crear el prestamo!']); 
        }
    }

    public function returnLoan(Loan $loan)
    {
        $loan->update(['return_date' => now(), 'status' => true]);
        return response()->json($loan->load(['book', 'user']));
    }
}
