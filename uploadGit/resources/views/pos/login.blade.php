<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KantinNabila</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md border-t-4 border-red-600">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Kantin<span class="text-red-600 font-light">Nabila</span></h1>
            <p class="text-sm text-slate-500 mt-1">Silakan masuk sesuai hak akses akun Anda</p>
        </div>

        @if($errors->any())
        <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-4">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="/login" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                <input type="email" name="email" required placeholder="nama@kantinnabila.com" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Masuk Sebagai</label>
                <select name="role_view" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500 bg-white">
                    <option value="kasir">Kasir (Menu Transaksi)</option>
                    <option value="admin">Admin (Dashboard Overview)</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl shadow transition-colors text-sm tracking-wide mt-2">
                MASUK APLIKASI
            </button>
        </form>
    </div>

</body>
</html>