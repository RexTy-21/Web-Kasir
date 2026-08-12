<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route Login & Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Route yang wajib login
Route::middleware(['auth'])->group(function () {
    
    // 1. Dashboard Admin
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }
        $totalProducts = \App\Models\Product::count();
        $totalTransactions = \App\Models\Transaction::count();
        $totalOmset = \App\Models\Transaction::sum('total_amount');
        return view('pos.dashboard', compact('totalProducts', 'totalTransactions', 'totalOmset'));
    });

    // 2. Laporan Keuangan (Admin)
    Route::get('/laporan', function () {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Akses ditolak.');
        }
        return app(PosController::class)->laporan();
    });

    // 3. Menu Transaksi / Kasir (Bisa diakses Admin & Kasir)
    Route::get('/', [PosController::class, 'index']);
    Route::post('/checkout', [PosController::class, 'checkout']);
    Route::get('/transaksi/{id}/struk', [PosController::class, 'struk']);
    
    // 4. Data Produk (Bisa diakses Admin & Kasir)
    Route::get('/produk', [ProductController::class, 'index']);
    Route::post('/produk', [ProductController::class, 'store']);
    Route::delete('/produk/{id}', [ProductController::class, 'destroy']);

    // 5. Akun & Password
    Route::get('/akun', function () {
        return view('pos.akun');
    });
    Route::put('/akun/password', [AuthController::class, 'updatePassword']);
});