@php
    date_default_timezone_set('Asia/Jakarta');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $transaction->invoice_no }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                background: white !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 flex justify-center items-center h-screen m-0" onload="window.print()">

    <div class="bg-white w-80 p-6 rounded-xl shadow-sm border border-slate-200 text-sm text-slate-800">
        <!-- Header Struk -->
        <div class="text-center pb-4 border-b border-dashed border-slate-300">
            <h1 class="font-bold text-lg tracking-wide">Kantin Nabila</h1>
            <p class="text-xs text-slate-500">Jl. Utama Toko Kantin Nabila</p>
        </div>

        <!-- Info Transaksi -->
        <div class="py-3 border-b border-dashed border-slate-300 space-y-1 text-xs">
            <div class="flex justify-between">
                <span class="text-slate-500">No. Invoice</span>
                <span class="font-semibold">{{ $transaction->invoice_no }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Tanggal & Jam</span>
                <span class="font-semibold">{{ date('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Kasir</span>
                <span class="font-semibold">{{ $transaction->user->name ?? 'Kasir' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Pembayaran</span>
                <span class="font-semibold uppercase">{{ $transaction->payment_method }}</span>
            </div>
        </div>

        <!-- Daftar Item Pembelian -->
        <div class="py-3 border-b border-dashed border-slate-300 space-y-2">
            @foreach($transaction->details as $detail)
            <div class="flex justify-between text-xs">
                <div>
                    <p class="font-bold text-slate-800">{{ $detail->product->name ?? 'Produk' }}</p>
                    <p class="text-slate-500">{{ $detail->qty }}x @ Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                </div>
                <div class="font-semibold text-slate-800 self-center">
                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Total Pembayaran -->
        <div class="py-3 border-b border-dashed border-slate-300 space-y-1 text-xs">
            <div class="flex justify-between font-bold text-sm">
                <span>Total Belanja</span>
                <span class="text-red-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Uang Diterima</span>
                <span>Rp {{ number_format($transaction->cash_received, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Kembalian</span>
                <span>Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer Struk -->
        <div class="pt-4 text-center text-xs text-slate-400 space-y-1">
            <p>Terima Kasih Atas Kunjungan Anda!</p>
            <p class="text-[10px]">Barang yang sudah dibeli tidak dapat ditukar.</p>
        </div>

        <!-- Tombol Kembali / Print Manual (Dijamin hilang saat dicetak) -->
        <div class="mt-4 no-print flex gap-2">
            <a href="/" class="flex-1 bg-slate-800 text-white text-center py-2 rounded-lg text-xs font-bold hover:bg-slate-900">Kembali ke Kasir</a>
            <button onclick="window.print()" class="flex-1 bg-red-600 text-white py-2 rounded-lg text-xs font-bold hover:bg-red-700">Cetak Ulang</button>
        </div>
    </div>

</body>
</html>