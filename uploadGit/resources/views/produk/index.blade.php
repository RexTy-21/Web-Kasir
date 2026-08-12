<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Produk - POS App</title>
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

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-full min-w-0 overflow-y-auto">
        
        <!-- Topbar -->
        <header class="bg-white p-4 shadow-sm flex justify-between items-center border-b border-slate-200">
            <h1 class="text-xl font-bold text-slate-800">Manajemen Data Produk</h1>
            <div class="flex items-center gap-3">
                <div class="text-sm text-slate-500">{{ date('d M Y') }}</div>
                <div class="h-6 w-px bg-slate-300"></div>
                <div class="font-semibold text-slate-700">Kasir: Budi</div>
            </div>
        </header>

        <!-- Content Grid -->
        <div class="p-6 flex gap-6 items-start">
            
            <!-- Form Tambah Produk (Sisi Kiri) -->
            <div class="w-96 bg-white rounded-xl shadow-sm border border-slate-200 p-5 shrink-0">
                <h2 class="font-bold text-lg text-slate-800 border-b pb-3 mb-4">Tambah Produk Baru</h2>
                
                <form action="/produk" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Nama Produk</label>
                        <input type="text" name="name" required placeholder="Contoh: Es Teh Manis" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Harga Jual (Rp)</label>
                        <input type="number" name="price" required placeholder="Contoh: 5000" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-1">Stok Awal</label>
                        <input type="number" name="stock" required placeholder="Contoh: 50" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:border-red-500">
                    </div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg shadow-md transition-colors">
                        Simpan Produk
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Produk (Sisi Kanan) -->
            <div class="flex-1 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-5 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h2 class="font-bold text-slate-700 text-lg">Daftar Produk Tersedia</h2>
                    <span class="bg-red-100 text-red-700 text-sm font-bold px-3 py-1 rounded-full">Total: {{ $products->count() }} Produk</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-100 text-slate-600 text-sm uppercase tracking-wider">
                                <th class="p-4 font-semibold border-b">SKU</th>
                                <th class="p-4 font-semibold border-b">Nama Produk</th>
                                <th class="p-4 font-semibold border-b text-center">Stok</th>
                                <th class="p-4 font-semibold border-b text-right">Harga</th>
                                <th class="p-4 font-semibold border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-700">
                            @forelse($products as $p)
                            <tr class="hover:bg-slate-50 border-b border-slate-100 transition-colors">
                                <td class="p-4 font-mono text-sm text-slate-500">{{ $p->sku }}</td>
                                <td class="p-4 font-bold text-slate-800">{{ $p->name }}</td>
                                <td class="p-4 text-center">
                                    <span class="bg-slate-100 px-2 py-1 rounded font-semibold">{{ $p->stock }}</span>
                                </td>
                                <td class="p-4 text-right font-semibold text-red-600">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                <td class="p-4 text-center">
                                    <form action="/produk/{{ $p->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-3 py-1 rounded text-sm font-semibold transition-colors">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-500">Belum ada produk yang terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>
</html>