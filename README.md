<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

Website Wisata Kabupaten Bulukumba

Dokumentasi lengkap pengembangan website wisata berbasis Laravel, Bootstrap 5, dan FilamentPHP.

🚀 Instalasi & Setup Project
1️⃣ Clone & Install Project
composer create-project laravel/laravel wisata-bulukumba
cd wisata-bulukumba

2️⃣ Konfigurasi Database

Buat database di phpMyAdmin:
db_wisata_bulukumba

Edit file .env:

DB_DATABASE=db_wisata_bulukumba

3️⃣ Install Filament Admin
composer require filament/filament -W
php artisan filament:install --panels

4️⃣ Install Laravel Breeze (Auth User)
composer require laravel/breeze --dev
php artisan breeze:install


Pilih opsi Blade → No → No/Yes

🗄️ Database Structure
🔹 Destination Model

Migration:

php artisan make:model Destination -m


Fields:

Field	Type
name	string
slug	string (unique)
description	text
location	string
price	decimal
image_url	string
🔹 Order Model

Migration:

php artisan make:model Order -m


Fields:

Field	Type
user_id	foreignId
destination_id	foreignId
quantity	integer
total_price	decimal
status	enum: pending, paid, cancelled

Jalankan migrasi:

php artisan migrate

🌱 Seeder Data Wisata

Buat seeder:

php artisan make:seeder DestinationSeeder


Jalankan:

php artisan db:seed --class=DestinationSeeder

🎨 Frontend — Bootstrap 5

📌 File Layout Utama
resources/views/layouts/main.blade.php
• Include Bootstrap 5 CDN
• Navbar (Beranda • Tiket Saya • Login/Register)

📌 Halaman Utama
resources/views/welcome.blade.php
• Hero section bergambar
• Grid cards destinasi (col-md-4)

📌 Halaman Detail Wisata
resources/views/destinations/show.blade.php
• Detail lokasi, harga
• Form beli tiket → OrderController

📌 Redirect Login → Beranda
Edit:

RegisteredUserController.php

AuthenticatedSessionController.php

🔐 Admin Panel — Filament
Reset & Generate Ulang (Jika Error)
# Hapus resource bermasalah
rm -rf app/Filament/Resources/OrderResource*

# Buat ulang
php artisan make:filament-resource Order --generate

Config OrderResource.php

📌 Lokasi:

app/Filament/Resources/OrderResource.php


Fitur:
✔ Nama user & wisata otomatis
✔ Format Rupiah
✔ Status badge warna-warni

(📌 Kode sudah sesuai best practice Filament)

🛡️ Security Access Admin

📌 File: app/Models/User.php

public function canAccessPanel(\Filament\Panel $panel): bool
{
    return $this->email === 'admin@gmail.com';
}

▶️ Cara Menjalankan Project
php artisan serve


🌍 Customer Website
http://127.0.0.1:8000/

🔑 Admin Panel
http://127.0.0.1:8000/admin

Login Admin:

Email: admin@gmail.com
Password: (sesuai yang dibuat saat register)

📝 Catatan & Troubleshooting

Jika ada error setelah ubah resource Filament:

composer dump-autoload
php artisan optimize:clear


⚠️ Wajib: Nama Resource → OrderResource (Singular)

