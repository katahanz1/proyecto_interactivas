<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $activeLoans = $user->loans()->where('status', 'borrowed')->with('book')->get();
        $loanHistory = $user->loans()->where('status', 'returned')->with('book')->latest()->get();

        return view('student.dashboard', compact('activeLoans', 'loanHistory'));
    }
}
