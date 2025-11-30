<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// 1. Import Class Penting untuk Filament
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

// 2. Tambahkan "implements FilamentUser" di sini
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 3. FUNGSI PEMBATAS AKSES ADMIN
    public function canAccessPanel(Panel $panel): bool
    {
        // GANTI email ini dengan email Admin Anda yang sebenarnya!
        // Hanya email yang tertulis di sini yang bisa masuk ke /admin
        
        return $this->email === 'admin@gmail.com'; 

        // Trik: Jika punya 2 admin, bisa pakai array seperti ini:
        // return in_array($this->email, ['admin@gmail.com', 'calvin@gmail.com']);
    }
}