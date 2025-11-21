<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->latest()->get();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $users = User::where('role', 'student')->get();
        $books = Book::where('stock', '>', 0)->get();
        return view('loans.create', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
        ]);

        $book = Book::find($request->book_id);

        if ($book->stock < 1) {
            return back()->withErrors(['book_id' => 'This book is out of stock.']);
        }

        Loan::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'loan_date' => $request->loan_date,
            'due_date' => $request->due_date,
            'status' => 'borrowed',
        ]);

        $book->decrement('stock');

        return redirect()->route('loans.index')->with('success', 'Loan created successfully.');
    }

    public function approve(Loan $loan)
    {
        if ($loan->status !== 'requested') {
            return back()->with('error', 'This loan is not in requested status.');
        }

        $book = $loan->book;
        if ($book->stock < 1) {
            return back()->with('error', 'Cannot approve. Book is out of stock.');
        }

        $loan->update([
            'status' => 'borrowed',
            'loan_date' => now(),
            'due_date' => now()->addDays(7), // Reset dates on approval
        ]);

        $book->decrement('stock');

        return back()->with('success', 'Loan approved successfully.');
    }

    public function show(Loan $loan)
    {
        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        // Not implementing edit for loans to keep it simple, only return
        return redirect()->route('loans.index');
    }

    public function update(Request $request, Loan $loan)
    {
        // This method will handle returning the book
        if ($loan->status == 'returned') {
            return back()->with('error', 'Book already returned.');
        }

        $loan->update([
            'return_date' => now(),
            'status' => 'returned',
        ]);

        $loan->book->increment('stock');

        return redirect()->route('loans.index')->with('success', 'Book returned successfully.');
    }

    public function destroy(Loan $loan)
    {
        if ($loan->status == 'borrowed') {
             $loan->book->increment('stock');
        }
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully.');
    }
    public function requestLoan(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::find($request->book_id);

        if ($book->stock < 1) {
            return back()->with('error', 'This book is out of stock.');
        }

        // Check if user already has a pending request or active loan for this book?
        // For simplicity, let's allow multiple for now, or maybe restrict 1 copy per user.
        $existingLoan = Loan::where('user_id', auth()->id())
                            ->where('book_id', $book->id)
                            ->whereIn('status', ['requested', 'borrowed'])
                            ->exists();

        if ($existingLoan) {
            return back()->with('error', 'You already have a request or active loan for this book.');
        }

        Loan::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(7), // Default 7 days
            'status' => 'requested',
        ]);

        // Do NOT decrement stock yet. Stock decrements on approval.

        return redirect()->route('books.catalog')->with('success', 'Loan requested successfully. Waiting for approval.');
    }
}
