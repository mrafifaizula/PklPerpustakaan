<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'kode_otp',
        'kadaluarsa_otp',
        'email_verified_at',
        'tlp',
        'image_user',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pinjambuku()
    {
        return $this->hasMany(pinjambuku::class, 'id_user');
    }

    public function hasAnyRole(array $roles)
    {
        return in_array($this->role, $roles);
    }

    public function deleteImage()
    {
        $imagePath = public_path('images/user/' . $this->image_user);

        if ($this->image_user && file_exists($imagePath)) {
            return unlink($imagePath);
        }

        return false;
    }
}