<?php

namespace App\Console\Commands;

use App\Services\ReportService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('library:report')]
#[Description('Command description')]
class GenerateLibraryReport extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(ReportService $reportService)
    {
        $report = $reportService->generate();

        $this->info('======================');
        $this->info('LIBROS MÁS PRESTADOS');
        $this->info('======================');

        foreach ($report['most_borrowed_books'] as $book) {
            $this->line(
                "{$book->title} ({$book->total_loans})"
            );
        }

        $this->newLine();

        $this->info('================================');
        $this->info('USUARIOS CON PRÉSTAMOS VENCIDOS');
        $this->info('================================');

        foreach ($report['users_with_overdue_loans'] as $user) {
            $this->line(
                "{$user->name} ({$user->email})"
            );
        }

        $this->newLine();

        $this->info('======================');
        $this->info('LIBROS SIN STOCK');
        $this->info('======================');

        foreach ($report['books_without_stock'] as $book) {
            $this->line($book->title);
        }

        return self::SUCCESS;
    }
}
