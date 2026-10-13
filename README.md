# Inventory & Stock Management System - RESTful API

Aplikasi RESTful API sistem manajemen inventaris barang dan pencatatan mutasi stok gudang berbasis Laravel dengan autentikasi JWT (JSON Web Token) dan Role-Based Access Control (RBAC).


---

## Tech Stack
- **Framework**: Laravel 11 / 12 (PHP 8.2+)
- **Database**: MySQL 8.0+
- **Authentication**: JWT Auth (`php-open-source-saver/jwt-auth`)
- **Testing**: PHPUnit / Feature Test
- **Code Standard**: PSR-12 (Laravel Pint)

---

## Cara Menjalankan Aplikasi

### 1. Clone & Masuk ke Direktori
```bash
cd backend
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment (.env)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Pastikan kredensial database di `.env` sudah sesuai dengan MySQL lokal Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tht_sii
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key & JWT Secret
```bash
php artisan key:generate
php artisan jwt:secret
```

### 5. Jalankan Migration & Seeder
Perintah ini akan membuat struktur tabel beserta 36 akun demo, 15 kategori, 15 supplier, 25 katalog produk, dan 20 riwayat mutasi stok:
```bash
php artisan migrate --seed
```

> **Alternatif File SQL Dump**: Jika tidak ingin menjalankan seeder, file SQL dump lengkap tersedia pada `database/dump.sql` dan dapat langsung di-import via phpMyAdmin / MySQL CLI.

### 6. Jalankan Local Development Server
```bash
php artisan serve
```
Aplikasi backend aktif di: `http://localhost:8000`

---

## Akun Demo untuk Pengujian

Semua akun demo menggunakan password seragam: `password`

| Role | Email Demo | Hak Akses Utama |
| :--- | :--- | :--- |
| **Superadmin** | `superadmin@demo.com` | Akses penuh, kelola akun user (admin & staff) |
| **Admin** | `admin@demo.com` | CRUD master produk, kategori, supplier, dan mutasi stok |
| **Staff** | `staff@demo.com` | Melihat katalog barang & mencatat mutasi keluar/masuk |

---

## Menjalankan Automated Feature Test
Proyek ini dilengkapi 26 skenario automated feature test (Auth JWT, CRUD Produk, RBAC, Valuasi Dashboard, dan Transaksi Mutasi):

```bash
php artisan test
```

---

## Ringkasan Endpoint API (Prefix `/api`)

### Autentikasi
| Method | Endpoint | Keterangan | Akses |
| :---: | :--- | :--- | :---: |
| `POST` | `/api/register` | Pendaftaran akun baru (default: staff) | Public |
| `POST` | `/api/login` | Login & generate JWT token | Public |
| `GET` | `/api/me` | Profil pengguna login | JWT Auth |
| `POST` | `/api/logout` | Invalidate token aktif | JWT Auth |

### Dashboard & Monitoring
| Method | Endpoint | Keterangan | Akses |
| :---: | :--- | :--- | :---: |
| `GET` | `/api/dashboard/summary` | Real-time valuasi aset, estimasi pasar, dan alert stok | JWT Auth |

### Master Data Produk & Kategori
| Method | Endpoint | Keterangan | Akses |
| :---: | :--- | :--- | :---: |
| `GET` | `/api/products` | List produk (Search, Filter Kategori, Status Stok, Pagination) | JWT Auth |
| `GET` | `/api/products/{id}` | Detail produk | JWT Auth |
| `POST` | `/api/products` | Tambah produk baru | Admin / Superadmin |
| `PUT` | `/api/products/{id}` | Update data produk | Admin / Superadmin |
| `DELETE` | `/api/products/{id}` | Soft delete produk | Admin / Superadmin |
| `GET` | `/api/categories` | List master kategori | JWT Auth |
| `POST` | `/api/categories` | Tambah kategori | Admin / Superadmin |
| `PUT` | `/api/categories/{id}` | Update kategori | Admin / Superadmin |
| `DELETE` | `/api/categories/{id}` | Hapus kategori (terproteksi relasi) | Admin / Superadmin |

### Master Supplier
| Method | Endpoint | Keterangan | Akses |
| :---: | :--- | :--- | :---: |
| `GET` | `/api/suppliers` | List supplier pemasok | JWT Auth |
| `POST` | `/api/suppliers` | Tambah supplier baru | Admin / Superadmin |
| `PUT` | `/api/suppliers/{id}` | Update data supplier | Admin / Superadmin |
| `DELETE` | `/api/suppliers/{id}` | Hapus supplier | Admin / Superadmin |

### Mutasi Stok (Audit Trail)
| Method | Endpoint | Keterangan | Akses |
| :---: | :--- | :--- | :---: |
| `GET` | `/api/stock-mutations` | Riwayat transaksi keluar/masuk (Paginated) | JWT Auth |
| `POST` | `/api/stock-mutations` | Catat barang masuk (IN) / barang keluar (OUT) | JWT Auth (All Roles) |

### Manajemen Pengguna (RBAC)
| Method | Endpoint | Keterangan | Akses |
| :---: | :--- | :--- | :---: |
| `GET` | `/api/users` | List seluruh akun pengguna | Superadmin Saja |
| `POST` | `/api/users` | Buat akun baru dengan role tertentu | Superadmin Saja |
| `PUT` | `/api/users/{id}` | Update role / data user | Superadmin Saja |
| `DELETE` | `/api/users/{id}` | Hapus akun user | Superadmin Saja |
