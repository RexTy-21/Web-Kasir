<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - KantinNabila</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Dashboard Admin</h1>
                <p class="text-sm text-slate-500">Ringkasan statistik operasional Kantin Nabila</p>
            </div>
            <div class="text-sm font-semibold text-slate-700 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200">
                Login sebagai: Admin
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <div class="text-sm font-semibold text-slate-500">Pendapatan Keseluruhan (Omset)</div>
                <div class="text-3xl font-bold text-slate-800 mt-2">Rp {{ number_format($totalOmset, 0, ',', '.') }}</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <div class="text-sm font-semibold text-slate-500">Total Transaksi Berhasil</div>
                <div class="text-3xl font-bold text-blue-600 mt-2">{{ $totalTransactions }} Transaksi</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <div class="text-sm font-semibold text-slate-500">Total Menu Produk</div>
                <div class="text-3xl font-bold text-red-600 mt-2">{{ $totalProducts }} Item</div>
            </div>
        </div>

        <!-- Tombol Akses Cepat -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <h2 class="font-bold text-slate-800 mb-4">Akses Cepat Pengelolaan</h2>
            <div class="flex flex-wrap gap-4">
                <a href="/" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm shadow">
                    Buka Kasir / Transaksi
                </a>
                <a href="/laporan" class="bg-slate-800 hover:bg-slate-900 text-white font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm shadow">
                    Kelola Laporan & Cetak
                </a>
            </div>
        </div>
    </main>

</body>
</html>