<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pinjambuku extends Model
{
    use HasFactory;
    public $fillable = ['jumlah', 'tanggal_pinjambuku', 'batas_pengembalian', 'status', 'user'];
    public $visible = ['jumlah', 'tanggal_pinjambuku', 'batas_pengembalian', 'status', 'user'];
    public $timestamps = true;

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function pinjambuku()
    {
        return $this->hasMany(pinjambuku::class, 'id_pinjambuku');
    }

}
