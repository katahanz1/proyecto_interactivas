<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendLoanReminders extends Command
{
    protected $signature = 'loans:send-reminders';
    protected $description = 'Send email reminders for loans due tomorrow';

    public function handle()
    {
        $loans = \App\Models\Loan::where('status', 'borrowed')
                        ->where('due_date', '=', now()->addDay()->format('Y-m-d'))
                        ->with(['user', 'book'])
                        ->get();

        foreach ($loans as $loan) {
            \Illuminate\Support\Facades\Mail::to($loan->user->email)->send(new \App\Mail\LoanDueReminder($loan));
        }

        $this->info('Reminders sent successfully.');
    }
}
