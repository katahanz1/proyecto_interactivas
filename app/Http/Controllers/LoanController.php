<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{
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
            return back()->withErrors(['book_id' => 'Este libro está agotado.']);
        }

        Loan::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'loan_date' => $request->loan_date,
            'due_date' => $request->due_date,
            'status' => 'borrowed',
        ]);

        $book->decrement('stock');

        return redirect()->route('loans.index')->with('success', 'Préstamo creado exitosamente.');
    }

    public function approve(Loan $loan)
    {
        if ($loan->status !== 'requested') {
            return back()->with('error', 'Este préstamo no está en estado solicitado.');
        }

        $book = $loan->book;
        if ($book->stock < 1) {
            return back()->with('error', 'No se puede aprobar. El libro está agotado.');
        }

        $loan->update([
            'status' => 'borrowed',
            'loan_date' => now(),
            'due_date' => now()->addDays(7),
        ]);

        $book->decrement('stock');

        return back()->with('success', 'Préstamo aprobado exitosamente.');
    }

    public function show(Loan $loan)
    {
        return view('loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        return redirect()->route('loans.index');
    }

    public function update(Request $request, Loan $loan)
    {
        if ($loan->status == 'returned') {
            return back()->with('error', 'El libro ya ha sido devuelto.');
        }

        $loan->update([
            'return_date' => now(),
            'status' => 'returned',
        ]);

        $loan->book->increment('stock');

        return redirect()->route('loans.index')->with('success', 'Libro devuelto exitosamente.');
    }

    public function destroy(Loan $loan)
    {
        if ($loan->status == 'borrowed') {
             $loan->book->increment('stock');
        }
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Préstamo eliminado exitosamente.');
    }
    public function requestLoan(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::find($request->book_id);

        if ($book->stock < 1) {
            return back()->with('error', 'Este libro está agotado.');
        }

        $existingLoan = Loan::where('user_id', auth()->id())
                            ->where('book_id', $book->id)
                            ->whereIn('status', ['requested', 'borrowed'])
                            ->exists();

        if ($existingLoan) {
            return back()->with('error', 'Ya tienes una solicitud o préstamo activo para este libro.');
        }

        Loan::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'requested',
        ]);

        return redirect()->route('books.catalog')->with('success', 'Préstamo solicitado exitosamente. Esperando aprobación.');
    }

    public function requestReturn(Loan $loan)
    {
        if ($loan->user_id !== auth()->id()) {
            abort(403);
        }

        if ($loan->status !== 'borrowed') {
            return back()->with('error', 'Solo se pueden devolver libros prestados.');
        }

        $loan->update([
            'status' => 'return_requested',
        ]);

        return back()->with('success', 'Devolución solicitada exitosamente. Esperando confirmación del administrador.');
    }
}
