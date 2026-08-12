<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Transaksi - KantinNabila</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">

    <!-- Sidebar -->
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
                <a href="/akun" class="block px-4 py-3 {{ Request::is('akun') ? 'bg-white text-red-700 font-bold shadow-sm' : 'hover:bg-red-600' }} rounded-lg transition-colors">Akun Kasir</a>
            @endif
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- Top Bar -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center shrink-0">
            <h1 class="text-xl font-bold text-slate-800">Menu Transaksi</h1>
            <div class="text-sm font-semibold text-slate-600">
                Kasir: <span class="text-red-700">{{ Auth::user()->name }}</span>
            </div>
        </header>

        <!-- Content Grid -->
        <div class="flex-1 flex overflow-hidden p-6 gap-6">
            <!-- List Produk -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <div class="mb-4">
                    <input type="text" id="searchProduct" placeholder="Cari nama produk..." class="w-full bg-white border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500">
                </div>
                <div class="flex-1 overflow-y-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 content-start pr-2" id="productList">
                    @foreach($products as $product)
                    <div onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }})" class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:border-red-500 cursor-pointer transition-all flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-slate-800">{{ $product->name }}</h3>
                            <p class="text-red-600 font-bold text-sm mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex justify-between items-center mt-4 text-xs text-slate-400 border-t pt-2">
                            <span class="bg-slate-100 px-2 py-0.5 rounded text-slate-600 font-mono">{{ $product->sku ?? 'PRD' }}</span>
                            <span>Stok: {{ $product->stock }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Keranjang Belanja -->
            <div class="w-96 bg-white rounded-xl shadow-sm border border-slate-200 flex flex-col shrink-0">
                <div class="p-4 border-b border-slate-200 font-bold text-slate-800">
                    Keranjang Belanja
                </div>

                <!-- Item List -->
                <div class="flex-1 overflow-y-auto p-4 space-y-3" id="cartItems">
                    <div class="text-center text-slate-400 py-20 text-sm" id="emptyCart">
                        Keranjang masih kosong
                    </div>
                </div>

                <!-- Checkout Section -->
                <div class="p-4 border-t border-slate-200 space-y-3 bg-slate-50 rounded-b-xl">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Subtotal</span>
                        <span class="font-bold text-slate-800" id="subtotalText">Rp 0</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Metode Pembayaran</label>
                        <select id="paymentMethod" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                            <option value="cash">Cash (Tunai)</option>
                            <option value="qris">QRIS</option>
                            <option value="transfer">Transfer Bank</option>
                        </select>
                    </div>

                    <div id="cashInputContainer">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Uang Diterima (Cash)</label>
                        <input type="number" id="cashReceived" value="0" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                    </div>

                    <div class="flex justify-between items-center pt-2 border-t border-slate-200">
                        <span class="font-bold text-slate-800">Total</span>
                        <span class="font-extrabold text-lg text-red-600" id="totalText">Rp 0</span>
                    </div>

                    <button onclick="checkout()" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl text-sm transition-colors shadow">
                        BAYAR SEKARANG
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Script Keranjang & Kasir -->
    <script>
        let cart = [];

        function addToCart(id, name, price, stock) {
            let existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                if (existingItem.qty < stock) {
                    existingItem.qty++;
                } else {
                    alert('Stok produk tidak mencukupi!');
                }
            } else {
                cart.push({ id, name, price, qty: 1, stock });
            }
            renderCart();
        }

        function updateQty(id, change) {
            let item = cart.find(item => item.id === id);
            if (item) {
                item.qty += change;
                if (item.qty <= 0) {
                    cart = cart.filter(i => i.id !== id);
                } else if (item.qty > item.stock) {
                    item.qty = item.stock;
                    alert('Stok maksimal tercapai!');
                }
            }
            renderCart();
        }

        function renderCart() {
            let container = document.getElementById('cartItems');
            let subtotalText = document.getElementById('subtotalText');
            let totalText = document.getElementById('totalText');

            container.innerHTML = '';
            if (cart.length === 0) {
                container.innerHTML = `<div class="text-center text-slate-400 py-20 text-sm">Keranjang masih kosong</div>`;
                subtotalText.innerText = 'Rp 0';
                totalText.innerText = 'Rp 0';
                return;
            }

            let subtotal = 0;
            cart.forEach(item => {
                subtotal += item.price * item.qty;
                container.innerHTML += `
                    <div class="flex justify-between items-center bg-white p-3 rounded-lg border border-slate-200 shadow-sm">
                        <div class="flex-1">
                            <h4 class="font-bold text-xs text-slate-800">${item.name}</h4>
                            <p class="text-xs text-red-600 font-semibold">Rp ${item.price.toLocaleString('id-ID')}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="updateQty(${item.id}, -1)" class="w-6 h-6 bg-slate-100 hover:bg-slate-200 rounded text-xs font-bold">-</button>
                            <span class="text-xs font-bold w-4 text-center">${item.qty}</span>
                            <button onclick="updateQty(${item.id}, 1)" class="w-6 h-6 bg-slate-100 hover:bg-slate-200 rounded text-xs font-bold">+</button>
                        </div>
                    </div>
                `;
            });

            subtotalText.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            totalText.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            // Nilai cashReceived dibiarkan statis / tidak diubah otomatis ke total harga
        }

        // Filter pencarian produk
        document.getElementById('searchProduct').addEventListener('input', function(e) {
            let keyword = e.target.value.toLowerCase();
            let products = document.querySelectorAll('#productList > div');
            products.forEach(card => {
                let name = card.querySelector('h3').innerText.toLowerCase();
                card.style.display = name.includes(keyword) ? 'flex' : 'none';
            });
        });

        // Toggle input cash jika metode bayar bukan cash
        document.getElementById('paymentMethod').addEventListener('change', function(e) {
            let cashContainer = document.getElementById('cashInputContainer');
            if(e.target.value !== 'cash') {
                cashContainer.style.display = 'none';
            } else {
                cashContainer.style.display = 'block';
            }
        });

        function checkout() {
            if (cart.length === 0) {
                alert('Keranjang belanja masih kosong!');
                return;
            }

            let paymentMethod = document.getElementById('paymentMethod').value;
            let cashReceived = document.getElementById('cashReceived').value;
            let total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

            if (paymentMethod === 'cash' && Number(cashReceived) < total) {
                alert('Uang diterima kurang dari total belanja!');
                return;
            }

            fetch('/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    items: cart,
                    payment_method: paymentMethod,
                    cash_received: paymentMethod === 'cash' ? cashReceived : total
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    window.location.href = `/transaksi/${data.transaction_id}/struk`;
                } else {
                    alert('Gagal melakukan checkout: ' + (data.message || 'Kesalahan sistem'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan sistem!');
            });
        }
    </script>
</body>
</html>