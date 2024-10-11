<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pinjambuku extends Model
{
    protected $fillable = [
        'jumlah',
        'denda',
        'pesan',
        'tanggal_pinjambuku',
        'batas_pengembalian',
        'tanggal_pengembalian',
        'status',
        'id_user',
        'id_buku'
    ];

    protected $visible = [
        'jumlah',
        'pesan',
        'tanggal_pinjambuku',
        'batas_pengembalian',
        'tanggal_pengembalian',
        'status',
        'user'
    ];

    public $timestamps = true;
    public function buku()
    {
        return $this->belongsTo(buku::class, 'id_buku');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
