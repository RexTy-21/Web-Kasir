<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pos.index', compact('products'));
    }

    public function checkout(Request $request)
    {
        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $product = Product::find($item['id']);
                $totalAmount += $product->price * $item['qty'];
            }

            $cashReceived = $request->cash_received ?? $totalAmount;
            $change = $cashReceived - $totalAmount;

            $transaction = Transaction::create([
                'invoice_no' => 'INV-' . date('Ymd') . rand(1000, 9999),
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'cash_received' => $cashReceived,
                'change' => $change,
            ]);

            foreach ($request->items as $item) {
                $product = Product::find($item['id']);
                
                // Menggunakan 'qty' sesuai nama kolom di database transaction_details
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $item['qty'],
                ]);

                // Kurangi stok produk
                $product->decrement('stock', $item['qty']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'transaction_id' => $transaction->id,
                'invoice' => $transaction->invoice_no,
                'change' => $change
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function struk($id)
    {
        $transaction = Transaction::with('details.product', 'user')->findOrFail($id);
        return view('pos.struk', compact('transaction'));
    }

    public function laporan()
    {
        $transactions = Transaction::with('user')->latest()->get();
        $totalTransactions = $transactions->count();
        $totalOmset = $transactions->sum('total_amount');
        return view('pos.laporan', compact('transactions', 'totalTransactions', 'totalOmset'));
    }
}