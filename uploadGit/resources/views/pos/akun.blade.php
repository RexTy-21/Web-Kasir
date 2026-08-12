<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Akun - KantinNabila</title>
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

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto p-6">
        <h1 class="text-2xl font-bold text-slate-800 mb-6">Profil {{ Auth::user()->role === 'admin' ? 'Akun Admin' : 'Akun Kasir' }}</h1>

        @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 p-3 rounded-xl text-sm mb-4 max-w-xl border border-emerald-200">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 text-red-600 p-3 rounded-xl text-sm mb-4 max-w-xl border border-red-200">
            {{ $errors->first() }}
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-xl space-y-6">
            <div class="flex items-center gap-4 pb-6 border-b border-slate-200">
                <div class="w-16 h-16 bg-red-100 text-red-700 font-bold text-2xl flex items-center justify-center rounded-full">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">{{ Auth::user()->name }}</h2>
                    <p class="text-sm text-slate-500 capitalize">{{ Auth::user()->role }} Kantin Nabila</p>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Nama Lengkap</span>
                    <span class="font-semibold text-slate-800">{{ Auth::user()->name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Email Login</span>
                    <span class="font-semibold text-slate-800">{{ Auth::user()->email }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Status Akun</span>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Aktif</span>
                </div>
            </div>

            <!-- Form Ubah Password -->
            <form action="/akun/password" method="POST" class="pt-4 border-t border-slate-200 space-y-4">
                @csrf
                @method('PUT')
                <h3 class="font-bold text-slate-800 text-sm">Ubah Password</h3>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Password Lama</label>
                    <input type="password" name="current_password" required placeholder="••••••••" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Password Baru (Minimal 6 karakter)</label>
                    <input type="password" name="new_password" required placeholder="••••••••" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                </div>

                <div class="flex justify-between items-center pt-2">
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors shadow">
                        Simpan Password Baru
                    </button>
                </div>
            </form>

            <!-- Tombol Logout -->
            <div class="pt-4 border-t border-slate-200 flex justify-between items-center">
                <span class="text-xs text-slate-400">Sesi aktif</span>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors shadow">
                        Logout (Keluar)
                    </button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>