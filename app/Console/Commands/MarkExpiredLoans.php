<?php

namespace App\Console\Commands;

use App\Models\Loan;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:mark-expired-loans')]
#[Description('Command description')]
class MarkExpiredLoans extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        Loan::where('status', 'active')
            ->whereDate(
                'due_date', '<', now()->subDays(15)
            )->update([
                'status' => 'expired'
            ]);
    }
}
