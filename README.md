# Sistem Presensi Pegawai

Aplikasi web presensi pegawai berbasis Laravel dengan Filament Admin Panel yang dilengkapi fitur deteksi keterlambatan otomatis, tracking lokasi GPS, dan laporan Excel.

![Laravel](https://img.shields.io/badge/Laravel-10.x-red)
![Filament](https://img.shields.io/badge/Filament-3.x-orange)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-green)

## Fitur Utama

### Presensi
- Check-in dan Check-out dengan timestamp otomatis
- Time Picker untuk input manual waktu presensi
- GPS Location tracking dengan Leaflet Maps
- Status kehadiran: Hadir, Izin, Sakit, Alpha
- Deteksi keterlambatan otomatis (check-in & check-out)
- Validasi: 1 presensi per hari per pegawai

### Sistem Keterlambatan
- **Jam Kerja**: 08:00 - 16:00
- **Terlambat Check-in**: Masuk LEWAT dari jam 08:00
- **Terlambat Check-out**: Pulang KURANG DARI atau SAMA DENGAN jam 16:00
- Perhitungan durasi keterlambatan dalam menit
- Visual indicator untuk status keterlambatan

### Laporan & Analytics
- Dashboard real-time dengan statistik:
  - Total Pegawai
  - Hadir Hari Ini
  - Terlambat
  - Izin, Sakit, Alpha
- Laporan web dengan filter:
  - Filter berdasarkan pegawai
  - Filter berdasarkan range tanggal
  - Statistik periode
- Export ke Excel (.xlsx) dengan data lengkap:
  - NIP, Nama, Tanggal
  - Jam Masuk & Keluar
  - Status Keterlambatan
  - Latitude & Longitude
  - Keterangan

### Admin Panel (Filament)
- Manajemen Data Pegawai (CRUD)
- Manajemen Data Presensi (CRUD)
- Filter & Search
- Widget Laporan Presensi
- UI Modern & Responsive

## Teknologi

- **Framework**: Laravel 10.x
- **Admin Panel**: Filament 3.x
- **Database**: MySQL 8.0+
- **Frontend**: 
  - Tailwind CSS
  - Alpine.js
  - Livewire
- **Maps**: Leaflet.js
- **Time Picker**: Flatpickr
- **Export**: Maatwebsite/Laravel-Excel
- **Icons**: Font Awesome 6

## Prasyarat

- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Node.js & NPM (opsional)
- WSL Ubuntu (untuk Windows) atau Linux/macOS

## Instalasi

### 1. Clone atau Buat Project

```bash
# Buat project Laravel baru
composer create-project laravel/laravel presensi-app

# Masuk ke direktori project
cd presensi-app
```

### 2. Install Dependencies

```bash
# Install Filament
composer require filament/filament:"^3.0"

# Install package export Excel
composer require maatwebsite/excel

# Install Filament Panel
php artisan filament:install --panels
```

### 3. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=presensi_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup MySQL

```bash
# Install MySQL (jika di WSL Ubuntu)
sudo apt update
sudo apt install mysql-server

# Start MySQL
sudo service mysql start

# Login dan buat database
sudo mysql -u root

# Di MySQL prompt:
CREATE DATABASE presensi_db;
EXIT;
```

### 5. Setup User MySQL untuk Laravel

```bash
sudo mysql -u root

# Buat user baru
CREATE USER 'laravel'@'localhost' IDENTIFIED BY 'password123';
GRANT ALL PRIVILEGES ON *.* TO 'laravel'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
EXIT;
```

Update `.env`:
```env
DB_USERNAME=laravel
DB_PASSWORD=password123
```

### 6. Jalankan Migration

```bash
php artisan migrate
```

### 7. Buat Admin User

```bash
php artisan make:filament-user
```

Masukkan:
- Name: Admin
- Email: admin@admin.com
- Password: password

### 8. Download Adminer (Opsional)

```bash
cd public
wget https://github.com/vrana/adminer/releases/download/v4.8.1/adminer-4.8.1.php -O adminer.php
cd ..
```

### 9. Publish Config Excel

```bash
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
```

### 10. Clear Cache & Jalankan Server

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Jalankan development server
php artisan serve
```

## Akses Aplikasi

- **Website Utama**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin
- **Adminer**: http://localhost:8000/adminer.php

### Login Admin
- Email: admin@admin.com
- Password: password

### Adminer Login
- System: MySQL
- Server: localhost
- Username: laravel
- Password: password123
- Database: presensi_db

## Struktur Database

### Tabel: `pegawais`
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary Key |
| nip | string | Nomor Induk Pegawai (unique) |
| nama | string | Nama Lengkap |
| email | string | Email (unique) |
| jabatan | string | Jabatan |
| divisi | string | Divisi |

### Tabel: `presensis`
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary Key |
| pegawai_id | bigint | Foreign Key ke pegawais |
| tanggal | date | Tanggal Presensi |
| jam_masuk | time | Waktu Check-in |
| jam_keluar | time | Waktu Check-out |
| status | enum | hadir, izin, sakit, alpha |
| is_late_check_in | boolean | Status Terlambat Masuk |
| is_late_check_out | boolean | Status Terlambat Pulang |
| late_duration_minutes | integer | Durasi Keterlambatan (menit) |
| latitude | decimal(10,8) | GPS Latitude |
| longitude | decimal(11,8) | GPS Longitude |
| keterangan | text | Keterangan |

## Cara Penggunaan

### Untuk Pegawai

#### 1. Check-in
1. Buka website utama
2. Klik tombol **"Check In"**
3. Pilih nama pegawai dari dropdown
4. Pilih status kehadiran (Hadir/Izin/Sakit/Alpha)
5. Jika status "Hadir", opsional atur waktu dengan time picker
6. Klik **"Dapatkan Lokasi Saat Ini"** untuk GPS tracking
7. Tambahkan keterangan (opsional)
8. Klik **"Kirim Presensi"**

#### 2. Check-out
1. Buka website utama
2. Klik tombol **"Check Out"**
3. Pilih nama pegawai
4. Klik **"Konfirmasi Check Out"**

### Untuk Admin

#### 1. Manajemen Pegawai
1. Login ke admin panel
2. Menu **"Pegawai"**
3. Tambah, Edit, atau Hapus data pegawai

#### 2. Manajemen Presensi
1. Menu **"Presensi"**
2. Lihat semua data presensi
3. Filter berdasarkan status atau keterlambatan
4. Edit atau hapus data presensi

#### 3. Melihat Laporan
1. Di Dashboard, lihat widget **"Laporan Presensi"**
2. Pilih pegawai (atau "Semua Pegawai")
3. Pilih tanggal mulai dan akhir
4. Klik **"Lihat Laporan"** untuk tampilan web
5. Atau klik **"Export Excel"** untuk download

#### 4. Export ke Excel
File Excel akan berisi:
- Data lengkap presensi
- Status keterlambatan
- Koordinat GPS
- Styling header berwarna
- Auto-sizing kolom

## Konfigurasi

### Jam Kerja

Edit `app/Models/Presensi.php`:

```php
// Jam kerja standard
const CHECK_IN_TIME = '08:00:00';   // Ubah sesuai kebutuhan
const CHECK_OUT_TIME = '16:00:00';  // Ubah sesuai kebutuhan
```

### Lokasi Default Map

Edit `resources/views/presensi/form.blade.php`:

```javascript
// Default: Semarang, Indonesia
let map = L.map('map').setView([-6.9666204, 110.4166495], 13);

// Ubah koordinat sesuai lokasi kantor Anda
```

## Troubleshooting

### Error: Access denied for user 'root'@'localhost'

**Solusi 1**: Reset password MySQL root
```bash
sudo mysql -u root
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';
FLUSH PRIVILEGES;
```

**Solusi 2**: Buat user baru (lihat langkah instalasi #5)

### Error: SQLSTATE[HY000] [2002] Connection refused

**Solusi**: Pastikan MySQL berjalan
```bash
sudo service mysql start
sudo service mysql status
```

### Geolocation tidak bekerja

**Solusi**: 
- Pastikan browser mengizinkan akses lokasi
- Gunakan HTTPS untuk production
- Di development, gunakan `localhost` bukan IP address

### Widget tidak muncul di Dashboard

**Solusi**:
```bash
php artisan filament:cache-components
php artisan optimize:clear
```

## Catatan Penting

### Keterlambatan
- **Check-in jam 08:00:00 tepat** = TIDAK terlambat
- **Check-in jam 08:00:01 atau lebih** = Terlambat
- **Check-out jam 16:00:00 atau kurang** = Terlambat (pulang cepat)
- **Check-out jam 16:00:01 atau lebih** = TIDAK terlambat

### Browser Storage
Aplikasi ini *IDAK menggunakan localStorage atau sessionStorage. Semua state disimpan di database.

## Keamanan

- Password di-hash menggunakan bcrypt
- CSRF protection enabled
- Input validation di server-side
- SQL injection protection via Eloquent ORM

##  Lisensi

Project ini bersifat open source untuk tujuan pembelajaran.

## Developer

Dibuat dengan menggunakan Laravel & Filament

## Kontribusi

Silakan fork repository ini dan buat pull request untuk kontribusi.

## Support

Jika ada pertanyaan atau masalah:
1. Cek dokumentasi Laravel: https://laravel.com/docs
2. Cek dokumentasi Filament: https://filamentphp.com/docs
3. Buka issue di repository

---

**Selamat menggunakan Sistem Presensi Pegawai!**
