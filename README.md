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

🛠 Teknologi yang Digunakan

Framework: Laravel 11

Language: PHP 8.2+

Database: MySQL

Admin Panel: FilamentPHP v3

Frontend UI: Bootstrap 5 (CDN)

Auth: Laravel Breeze (Customer) & Filament Auth (Admin)

🚀 Langkah 1: Instalasi & Persiapan

Install Laravel Project

composer create-project laravel/laravel wisata-bulukumba
cd wisata-bulukumba


Setup Database (.env)
Buat database di phpMyAdmin bernama db_wisata_bulukumba, lalu edit file .env:

DB_DATABASE=db_wisata_bulukumba


Install Filament (Admin Panel)

composer require filament/filament -W
php artisan filament:install --panels


Install Laravel Breeze (Login User)

composer require laravel/breeze --dev
php artisan breeze:install


Pilih opsi: Blade -> No -> No/Yes.

🗄️ Langkah 2: Database (Model & Migration)

Buat Model & Migration

php artisan make:model Destination -m
php artisan make:model Order -m


Struktur Tabel destinations

name (string)

slug (string, unique)

description (text)

location (string)

price (decimal)

image_url (string)

Struktur Tabel orders

user_id (foreignId)

destination_id (foreignId)

quantity (integer)

total_price (decimal)

status (enum: pending, paid, cancelled)

Jalankan Migrasi

php artisan migrate


🌱 Langkah 3: Seeder (Data Dummy)

Mengisi data wisata otomatis (Pantai Bara, Apparallang, dll).

Buat Seeder

php artisan make:seeder DestinationSeeder


Jalankan Seeder

php artisan db:seed --class=DestinationSeeder


💻 Langkah 4: Frontend (Bootstrap 5)

Setup Layout (resources/views/layouts/main.blade.php)

Include Bootstrap 5 CDN di <head>.

Buat Navbar (Beranda, Tiket Saya, Login/Register).

Halaman Utama (welcome.blade.php)

Menggunakan Hero Section dengan background gambar.

Menggunakan Grid System (col-md-4) untuk menampilkan kartu wisata.

Style Card: Menggunakan card-img-overlay agar teks berada di atas gambar (mirip style Wonderful Indonesia).

Halaman Detail & Beli (destinations/show.blade.php)

Menampilkan detail wisata.

Form input jumlah tiket (POST ke OrderController).

Perbaikan Redirect Login
Mengubah redirect default dari /dashboard ke / (Beranda) di file:

app/Http/Controllers/Auth/RegisteredUserController.php

app/Http/Controllers/Auth/AuthenticatedSessionController.php

⚙️ Langkah 5: Admin Panel (Filament)

Ini adalah bagian yang paling krusial. Kita menggunakan OrderResource untuk mengelola pesanan.

A. Reset & Generate Ulang (Solusi Anti-Error)

Jika terjadi error "Class not available" atau menu hilang, lakukan reset:

# Hapus folder lama yang bermasalah
Remove-Item -Path "app\Filament\Resources\OrderResource" -Recurse -Force
Remove-Item -Path "app\Filament\Resources\Orders" -Recurse -Force
Remove-Item -Path "app\Filament\Resources\OrderResource.php" -Force

# Generate ulang
php artisan make:filament-resource Order --generate


B. Kode Final OrderResource.php

Lokasi: app/Filament/Resources/OrderResource.php.
Fitur: Mengubah ID menjadi Nama, Dollar menjadi Rupiah, dan Status Warna-warni.

// Pastikan namespace benar
namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    
    // Konfigurasi Menu Sidebar
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Daftar Pesanan';
    protected static ?string $navigationGroup = 'Transaksi';

    // Form Edit (Admin mengubah status bayar)
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Pesanan')->schema([
                Forms\Components\TextInput::make('user.name')->label('Nama Pemesan')->disabled(),
                Forms\Components\TextInput::make('destination.name')->label('Wisata')->disabled(),
                Forms\Components\TextInput::make('total_price')->label('Total')->prefix('Rp')->disabled(),
            ])->columns(2),

            Forms\Components\Section::make('Update Status')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Lunas',
                        'cancelled' => 'Batal'
                    ])
                    ->required()
            ]),
        ]);
    }

    // Tabel Daftar Pesanan
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i'),
            Tables\Columns\TextColumn::make('user.name')->searchable(),
            Tables\Columns\TextColumn::make('destination.name'),
            Tables\Columns\TextColumn::make('total_price')->money('IDR'), // Format Rupiah
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'paid' => 'success',
                    'cancelled' => 'danger',
                }),
        ])
        ->defaultSort('created_at', 'desc');
    }
    
    // ... (Code pages standard)
}


🔒 Langkah 6: Keamanan (Security)

Membatasi akses /admin hanya untuk email admin tertentu.

File: app/Models/User.php

Implement FilamentUser.

Tambahkan fungsi canAccessPanel:

public function canAccessPanel(\Filament\Panel $panel): bool
{
    // Hanya email ini yang boleh masuk admin
    return $this->email === 'admin@gmail.com';
}


🚀 Cara Menjalankan Project

Buka Terminal dan jalankan server:

php artisan serve


Akses Website Pengunjung:
Buka http://127.0.0.1:8000

Akses Admin Panel:
Buka http://127.0.0.1:8000/admin

Email: admin@gmail.com

Password: (Sesuai yang dibuat saat register)

📝 Catatan Penting

Jika mengubah file Filament dan terjadi error, selalu jalankan:
composer dump-autoload dan php artisan optimize:clear.

Folder Resource Filament WAJIB bernama OrderResource (Singular), bukan Orders.

Selesai! Project siap digunakan untuk Tugas Kuliah. 🎉

