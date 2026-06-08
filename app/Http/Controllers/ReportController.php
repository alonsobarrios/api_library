<?php

namespace App\Http\Controllers;

use App\Services\ReportService;

class ReportController extends Controller
{
    public function index(ReportService $reportService)
    {
        return response()->json(
            $reportService->generate()
        );
    }
}
