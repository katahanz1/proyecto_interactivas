<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function libraryCard()
    {
        $user = auth()->user();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.library_card', compact('user'));
        return $pdf->download('library_card.pdf');
    }

    public function overdueReport()
    {
        $overdueLoans = Loan::where('status', 'borrowed')
                            ->where('due_date', '<', now())
                            ->with(['user', 'book'])
                            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.overdue', compact('overdueLoans'));
        return $pdf->download('overdue_report.pdf');
    }

    public function historyReport()
    {
        $user = auth()->user();
        $loans = $user->loans()->with('book')->latest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.history', compact('loans', 'user'));
        return $pdf->download('loan_history.pdf');
    }
}
