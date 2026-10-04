# Laravel5D — Beauty Booking System

Aplikasi pemesanan (booking) layanan kecantikan berbasis **Laravel**. Pelanggan dapat memesan satu atau beberapa layanan dengan beautician tertentu pada tanggal dan jam yang dipilih, sedangkan admin mengelola data master (beautician, kategori, dan layanan) serta memantau transaksi booking.

## Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Teknologi](#teknologi)
- [Struktur Database (ERD)](#struktur-database-erd)
- [Instalasi](#instalasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)

## Fitur Utama

- Dua peran pengguna: `admin` dan `customer`
- Data master **Users**, **Beauticians**, **Categories**, dan **Services**
- Transaksi **Bookings** dengan kode booking unik (`booking_code`)
- Satu booking dapat berisi banyak layanan (tabel pivot `booking_service`)
- Status booking: `pending`, `confirmed`, `completed`, `canceled`
- Status beautician: `active` dan `inactive`
- Harga layanan disimpan pada setiap item booking sehingga riwayat transaksi tetap akurat meskipun harga layanan berubah

## Teknologi

- [Laravel](https://laravel.com) (PHP)
- Composer — manajemen dependensi PHP
- npm — manajemen dependensi frontend
- Database relasional (MySQL/MariaDB atau sejenisnya, diatur lewat `.env`)

## Struktur Database (ERD)

![ERD](docs/erd.jpg)

### Tabel

| Tabel | Tipe | Keterangan |
|---|---|---|
| `users` | Master | Data akun admin dan customer |
| `beauticians` | Master | Data beautician |
| `categories` | Master | Kategori layanan |
| `services` | Master | Daftar layanan beserta harga dan durasi |
| `bookings` | Transaksi | Data pemesanan |
| `booking_service` | Pivot | Layanan yang dipesan pada setiap booking |

### Detail Kolom

**users**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT | Primary key |
| `name` | VARCHAR(255) | |
| `email` | VARCHAR(255) | Unique |
| `password` | VARCHAR(255) | |
| `phone` | VARCHAR(20) | |
| `role` | ENUM | `admin`, `customer` |
| `created_at` | TIMESTAMP | |

**beauticians**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT | Primary key |
| `name` | VARCHAR(255) | |
| `specialty` | VARCHAR(255) | |
| `photo` | VARCHAR(255) | |
| `status` | ENUM | `active`, `inactive` |
| `created_at` | TIMESTAMP | |

**categories**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT | Primary key |
| `name` | VARCHAR(255) | |
| `slug` | VARCHAR(255) | Unique |

**services**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT | Primary key |
| `category_id` | BIGINT | Foreign key → `categories.id` |
| `name` | VARCHAR(255) | |
| `description` | TEXT | |
| `price` | DECIMAL | |
| `duration_minutes` | INTEGER | Durasi layanan (menit) |
| `photo` | VARCHAR(255) | |

**bookings**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT | Primary key |
| `booking_code` | VARCHAR(50) | Unique |
| `user_id` | BIGINT | Foreign key → `users.id` |
| `beautician_id` | BIGINT | Foreign key → `beauticians.id` |
| `booking_date` | DATE | |
| `start_time` | TIME | |
| `total_price` | DECIMAL | |
| `status` | ENUM | `pending`, `confirmed`, `completed`, `canceled` |
| `notes` | TEXT | |
| `created_at` | TIMESTAMP | |

**booking_service**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT | Primary key |
| `booking_id` | BIGINT | Foreign key → `bookings.id` |
| `service_id` | BIGINT | Foreign key → `services.id` |
| `price` | DECIMAL | Harga layanan saat booking dibuat |

### Relasi Antar Tabel

- `users` **1 — N** `bookings`: satu user dapat memiliki banyak booking
- `beauticians` **1 — N** `bookings`: satu beautician dapat menangani banyak booking
- `bookings` **1 — N** `booking_service`: satu booking dapat berisi banyak layanan
- `services` **1 — N** `booking_service`: satu layanan dapat muncul di banyak booking
- `categories` **1 — N** `services`: satu kategori memiliki banyak layanan

> Secara efektif, `bookings` dan `services` berhubungan **many-to-many** melalui tabel `booking_service`.

## Instalasi

```bash
# Clone the repository
git clone https://github.com/nadsyaf/laravel5d
cd laravel5d

# Install dependencies
composer install
npm install

# Configure the environment
cp .env.example .env
php artisan key:generate

# Create the schema and seed the categories
php artisan migrate --seed
```

> Sebelum menjalankan `php artisan migrate --seed`, pastikan konfigurasi database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, dll.) di file `.env` sudah disesuaikan dengan database lokal Anda.

Perintah `php artisan migrate --seed` akan membuat seluruh skema tabel sekaligus mengisi data awal **categories**.

## Menjalankan Aplikasi

Jalankan kedua server development berikut (di terminal terpisah):

```bash
# Start the development servers
npm run dev
php artisan serve
```

Setelah itu, buka aplikasi di browser melalui alamat yang ditampilkan oleh `php artisan serve` (umumnya `http://127.0.0.1:8000`).