<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'student')->count();
        $activeLoans = Loan::where('status', 'borrowed')->count();
        $overdueLoans = Loan::where('status', 'borrowed')
                            ->where('due_date', '<', now())
                            ->count();

        $recentLoans = Loan::with(['user', 'book'])
                           ->latest()
                           ->take(5)
                           ->get();

        return view('admin.dashboard', compact('totalBooks', 'totalUsers', 'activeLoans', 'overdueLoans', 'recentLoans'));
    }
}
