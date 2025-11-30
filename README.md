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

🏖️ Wisata Bulukumba - Sistem Pemesanan Tiket WisataProject website untuk Dinas Pariwisata Kabupaten Bulukumba. Website ini memungkinkan pengunjung melihat destinasi wisata, memesan tiket, dan Admin dapat mengelola pesanan melalui dashboard modern.🛠️ Tech StackFramework: Laravel 11Language: PHP 8.2+Database: MySQLAdmin Panel: FilamentPHP v3Frontend: Bootstrap 5 + Blade TemplatesAuth: Laravel Breeze (Customer) & Filament Auth (Admin)🚀 Langkah Instalasi & Setup (Versi Anti-Error)Ikuti langkah ini secara berurutan untuk menghindari konflik versi atau error folder.1. Instalasi Dasar# 1. Buat Project Laravel Baru
composer create-project laravel/laravel wisata-bulukumba
cd wisata-bulukumba

# 2. Setup Database (.env)
# Pastikan buat database kosong bernama 'db_wisata_bulukumba' di phpMyAdmin
# Lalu edit file .env:
# DB_DATABASE=db_wisata_bulukumba

# 3. Install Filament (Gunakan flag -W agar versi kompatibel)
composer require filament/filament -W
php artisan filament:install --panels

# 4. Install Laravel Breeze (Pilih: Blade -> No -> No/Yes)
composer require laravel/breeze --dev
php artisan breeze:install
2. Database MigrationBuat tabel destinations dan orders.Edit file migration di database/migrations/:Tabel Destinations:Schema::create('destinations', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description');
    $table->string('location');
    $table->decimal('price', 12, 2);
    $table->string('image_url')->nullable();
    $table->timestamps();
});
Tabel Orders:Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
    $table->integer('quantity');
    $table->decimal('total_price', 12, 2);
    $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
    $table->string('payment_proof')->nullable();
    $table->timestamps();
});
Llalu jalankan: php artisan migrate👮‍♂️ Konfigurasi Admin (Filament)Ini adalah bagian krusial. Ikuti kode di bawah ini agar tidak terjadi error "Class not found" atau masalah tampilan.1. Buat Resource (Otomatis)Jangan buat manual! Biarkan Laravel yang generate foldernya.php artisan make:filament-resource Destination
php artisan make:filament-resource Order --generate
2. Setup OrderResource.php (Versi Final)Lokasi: app/Filament/Resources/OrderResource.phpKode ini sudah memperbaiki masalah Import Class, Format Rupiah, dan Nama User.<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Daftar Pesanan';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pesanan')
                    ->schema([
                        Forms\Components\TextInput::make('user.name')->label('Nama Pemesan')->disabled(),
                        Forms\Components\TextInput::make('destination.name')->label('Wisata Tujuan')->disabled(),
                        Forms\Components\TextInput::make('quantity')->label('Jumlah Tiket')->disabled(),
                        Forms\Components\TextInput::make('total_price')->label('Total Bayar')->prefix('Rp')->disabled(),
                    ])->columns(2),
                Forms\Components\Section::make('Update Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status Pembayaran')
                            ->options([
                                'pending' => 'Pending (Belum Bayar)',
                                'paid' => 'Paid (Lunas)',
                                'cancelled' => 'Cancelled (Batal)',
                            ])
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->label('Tanggal'),
                Tables\Columns\TextColumn::make('user.name')->label('Pemesan')->searchable(),
                Tables\Columns\TextColumn::make('destination.name')->label('Wisata'),
                Tables\Columns\TextColumn::make('total_price')->money('IDR')->label('Total'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'cancelled' => 'danger',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([ Tables\Actions\EditAction::make() ]);
    }
    
    public static function getRelations(): array { return []; }
    public static function getPages(): array {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
3. Batasi Akses Admin (Security)Agar hanya email tertentu yang bisa login ke Admin Panel.Edit app/Models/User.php:use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    // ... code lain ...

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->email === 'admin@gmail.com'; // Ganti dengan email admin Anda
    }
}
🎨 Setup Frontend (Bootstrap 5)1. Routing & ControllerBuat FrontController dan OrderController lalu atur route di routes/web.php.Fix Redirect: Pastikan di AuthenticatedSessionController.php (Login) dan RegisteredUserController.php (Register), redirect diarahkan ke route('home'), bukan dashboard.2. Tampilan (Blade)Layout Utama: Gunakan Bootstrap 5 CDN di layouts/main.blade.php.Homepage (welcome.blade.php): Gunakan Grid System (col-md-4) untuk menampilkan kartu wisata agar responsif 3 kolom.Contoh Grid Card Destinasi:<div class="col-12 col-md-4 mb-4">
    <div class="card border-0 shadow-sm h-100 text-white">
        <img src="{{ $dest->image_url }}" class="card-img" style="height: 350px; object-fit: cover;">
        <div class="card-img-overlay d-flex align-items-end">
            <div>
                <h5 class="fw-bold">{{ $dest->name }}</h5>
                <small>Rp {{ number_format($dest->price) }}</small>
            </div>
        </div>
    </div>
</div>
🧪 Cara Menjalankan ProjectGenerate Data Dummy (Seeder):php artisan make:seeder DestinationSeeder
# (Isi data Pantai Bara, Apparallang, dll)
php artisan db:seed --class=DestinationSeeder
Buat Akun Admin:php artisan make:filament-user
# Name: Admin
# Email: admin@gmail.com (Wajib sama dengan di User Model)
# Password: password
Jalankan Server:php artisan optimize:clear
php artisan serve
Akses:Pengunjung: http://127.0.0.1:8000Admin Panel: http://127.0.0.1:8000/admin📝 Catatan PentingJika menu Admin hilang atau terjadi error Class not available, jalankan perintah composer dump-autoload dan php artisan optimize:clear.Sistem pembayaran menggunakan metode Manual Transfer (User upload bukti -> Admin set status 'Paid' manual).Dibuat untuk Tugas Kuliah - Wisata BulukumbaSelamat Coding! 🚀

