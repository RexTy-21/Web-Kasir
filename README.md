# 🛍️ Aplikasi POS (Point of Sales) - Kantin Nabila

Aplikasi Point of Sales (POS) berbasis web yang dibangun menggunakan **Laravel** untuk memudahkan pengelolaan transaksi kasir, manajemen produk, pencatatan stok, dan pelaporan keuangan harian di **Kantin Nabila**.

## 🚀 Fitur Utama
* **Manajemen Autentikasi & Multi-Role**: Hak akses terpisah antara Admin dan Kasir (nama kasir otomatis tercatat di setiap transaksi dan struk).
* **Menu Kasir (Transaksi)**: Pencarian produk real-time, keranjang belanja interaktif, perhitungan total belanja, metode pembayaran (Cash, QRIS, Transfer), dan uang kembalian otomatis.
* **Cetak Struk Otomatis**: Fitur cetak struk berbasis HTML/CSS yang ramah printer thermal/PDF dengan tombol kontrol print tersembunyi saat dicetak.
* **Manajemen Produk & Stok**: Pengelolaan data produk, harga, SKU, dan pengurangan stok otomatis setiap kali transaksi berhasil.
* **Laporan Toko**: Rekapitulasi data transaksi, total omset, dan riwayat penjualan lengkap.

## 🛠️ Teknologi
* **Backend**: PHP 8.x / Laravel 10
* **Frontend**: Blade Templating, Tailwind CSS
* **Database**: MySQL

## ⚙️ Cara Instalasi
1. **Clone repository**: `git clone https://github.com/RexTy-21/Web-Kasir.git`
2. **Masuk folder**: `cd Web-Kasir`
3. **Install dependencies**: `composer install`
4. **Setup env**: `cp .env.example .env` (sesuaikan database di dalam file .env)
5. **Key generate**: `php artisan key:generate`
6. **Migrate database**: `php artisan migrate --seed`
7. **Jalankan server**: `php artisan serve`

## Akun dummy
email : budi@kantinnabila.com
pass : password123

---
*Dibuat untuk kebutuhan pengembangan portofolio sistem informasi.*
