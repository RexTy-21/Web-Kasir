<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - KantinNabila</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">

   <aside class="w-64 bg-red-700 text-white flex flex-col shadow-lg shrink-0">
    <div class="p-5 text-2xl font-bold border-b border-red-800 tracking-wider">
        Kantin<span class="font-light">Nabila</span>
    </div>
    <nav class="flex-1 p-4 space-y-2">
        @if(Auth::check() && Auth::user()->role === 'admin')
            <!-- Menu Khusus Admin (Lengkap) -->
            <a href="/dashboard" class="block px-4 py-3 {{ Request::is('dashboard') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Dashboard Admin</a>
            <a href="/" class="block px-4 py-3 {{ Request::is('/') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Menu Kasir</a>
            <a href="/laporan" class="block px-4 py-3 {{ Request::is('laporan') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Laporan Toko</a>
            <a href="/produk" class="block px-4 py-3 {{ Request::is('produk') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Data Produk</a>
            <a href="/akun" class="block px-4 py-3 {{ Request::is('akun') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Akun Admin</a>
        @else
            <!-- Menu Khusus Kasir (Tanpa Laporan) -->
            <a href="/" class="block px-4 py-3 {{ Request::is('/') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Transaksi</a>
            <a href="/produk" class="block px-4 py-3 {{ Request::is('produk') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Data Produk</a>
            <a href="/akun" class="block px-4 py-3 {{ Request::is('akun') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Akun Kasir</a>
        @endif
    </nav>
</aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto p-6">
        <h1 class="text-2xl font-bold text-slate-800 mb-6">Manajemen Data Produk</h1>

        @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 p-3 rounded-xl text-sm mb-4 border border-emerald-200">
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @if(Auth::user()->role === 'admin')
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 h-fit">
                <h2 class="font-bold text-lg text-slate-800 mb-4 pb-2 border-b">Tambah Produk</h2>
                <form action="/produk" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Produk</label>
                        <input type="text" name="name" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kategori</label>
                        <select name="category_id" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-white">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Harga (Rp)</label>
                        <input type="number" name="price" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Stok</label>
                        <input type="number" name="stock" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded-xl text-sm">Simpan</button>
                </form>
            </div>
            @endif

            <div class="{{ Auth::user()->role === 'admin' ? 'lg:col-span-2' : 'lg:col-span-3' }} bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="font-bold text-lg text-slate-800 mb-4 pb-2 border-b">Daftar Produk</h2>
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b text-slate-500 bg-slate-50">
                            <th class="p-3">SKU</th>
                            <th class="p-3">Nama</th>
                            <th class="p-3">Harga</th>
                            <th class="p-3">Stok</th>
                            @if(Auth::user()->role === 'admin')
                            <th class="p-3 text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr class="border-b">
                            <td class="p-3">{{ $product->sku }}</td>
                            <td class="p-3 font-bold">{{ $product->name }}</td>
                            <td class="p-3 text-red-600 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="p-3">{{ $product->stock }}</td>
                            @if(Auth::user()->role === 'admin')
                            <td class="p-3 text-center">
                                <form action="/produk/{{ $product->id }}" method="POST" onsubmit="return confirm('Hapus produk?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-100 text-red-700 px-3 py-1 rounded text-xs font-bold">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>