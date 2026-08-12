<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - KantinNabila</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
            shadow-sm, rounded-xl { box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">

    <aside class="w-64 bg-red-700 text-white flex flex-col shadow-lg shrink-0">
    <div class="p-5 text-2xl font-bold border-b border-red-800 tracking-wider">
        Kantin<span class="font-light">Nabila</span>
    </div>
    <nav class="flex-1 p-4 space-y-2">
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="/dashboard" class="block px-4 py-3 {{ Request::is('dashboard') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Dashboard Admin</a>
            <a href="/" class="block px-4 py-3 {{ Request::is('/') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Menu Kasir</a>
            <a href="/laporan" class="block px-4 py-3 {{ Request::is('laporan') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Laporan Toko</a>
            <a href="/produk" class="block px-4 py-3 {{ Request::is('produk') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Data Produk</a>
            <a href="/akun" class="block px-4 py-3 {{ Request::is('akun') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Akun Admin</a>
        @else
            <a href="/" class="block px-4 py-3 {{ Request::is('/') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Transaksi</a>
            <a href="/produk" class="block px-4 py-3 {{ Request::is('produk') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Data Produk</a>
            <a href="/laporan" class="block px-4 py-3 {{ Request::is('laporan') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Laporan</a>
            <a href="/akun" class="block px-4 py-3 {{ Request::is('akun') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Akun Kasir</a>
        @endif
    </nav>
</aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto p-6">
        
        <!-- Header & Tombol Cetak -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Laporan Riwayat Transaksi</h1>
                <p class="text-sm text-slate-500">Rekapitulasi seluruh penjualan kasir</p>
            </div>
            <button onclick="window.print()" class="no-print bg-slate-800 hover:bg-slate-900 text-white font-semibold px-4 py-2 rounded-xl shadow transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Laporan
            </button>
        </div>

        <!-- Info Ringkasan Penjualan Hari Ini -->
        @php
            $today = date('Y-m-d');
            $todayTransactions = $transactions->filter(function($item) use ($today) {
                return $item->created_at->format('Y-m-d') === $today;
            });
            $todayOmset = $todayTransactions->sum('total_amount');
            $todayCount = $todayTransactions->count();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <div class="text-sm font-semibold text-slate-500">Total Transaksi Hari Ini</div>
                <div class="text-2xl font-bold text-slate-800 mt-1">{{ $todayCount }} Transaksi</div>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <div class="text-sm font-semibold text-slate-500">Omset Penjualan Hari Ini</div>
                <div class="text-2xl font-bold text-red-600 mt-1">Rp {{ number_format($todayOmset, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Tabel Riwayat Transaksi -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-600 text-sm border-b border-slate-200">
                        <th class="p-4">No. Invoice</th>
                        <th class="p-4">Tanggal & Waktu</th>
                        <th class="p-4">Metode Bayar</th>
                        <th class="p-4">Total Amount</th>
                        <th class="p-4 text-center no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm text-slate-700">
                    @forelse($transactions as $trx)
                    <tr>
                        <td class="p-4 font-semibold text-slate-900">{{ $trx->invoice_no }}</td>
                        <td class="p-4">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $trx->payment_method === 'Cash' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $trx->payment_method }}
                            </span>
                        </td>
                        <td class="p-4 font-bold text-slate-900">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                        <td class="p-4 text-center no-print">
                            <a href="/transaksi/{{ $trx->id }}/struk" target="_blank" class="text-red-600 hover:text-red-800 font-semibold text-xs bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                Lihat Struk
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-slate-400">Belum ada riwayat transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

</body>
</html>