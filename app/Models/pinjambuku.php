<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pinjambuku extends Model
{
    use HasFactory;

    protected $fillable = ['jumlah', 'tanggal_pinjambuku', 'batas_pengembalian', 'status', 'user'];
    protected $visible = ['jumlah', 'tanggal_pinjambuku', 'batas_pengembalian', 'status', 'user'];
    public $timestamps = true;

    public function buku()
    {
        return $this->belongsTo(buku::class, 'id_buku');
    }

    public function user()
    {
        return $this->belongsTo(user::class, 'id_user');
    }

    public function denda()
    {
        return $this->hasMany(denda::class, 'id_pinjambuku');
    }
}