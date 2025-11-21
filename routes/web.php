<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);
    Route::resource('loans', LoanController::class);

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');

    Route::get('/reports/library-card', [ReportController::class, 'libraryCard'])->name('reports.library_card');
    Route::get('/reports/overdue', [ReportController::class, 'overdueReport'])->name('reports.overdue');
    Route::get('/reports/history', [ReportController::class, 'historyReport'])->name('reports.history');

    Route::get('/catalog', [BookController::class, 'catalog'])->name('books.catalog');
    Route::post('/loans/request', [LoanController::class, 'requestLoan'])->name('loans.request');
    Route::patch('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
});

require __DIR__.'/auth.php';
