<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pinjambuku extends Model
{
    use HasFactory;
    public $fillable = ['jumlah', 'tanggal_pinjambuku', 'tanggal_kembali', 'status', 'user'];
    public $visible = ['jumlah', 'tanggal_pinjambuku', 'tanggal_kembali', 'status', 'user'];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(user::class, 'id_user');

    }

    public function buku()
    {
        return $this->belongsTo(buku::class, 'id_buku');

    }

    public function pinjambuku()
    {
        return $this->hasMany(pinjambuku::class, 'id_pinjambuku');
    }

}
