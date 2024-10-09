<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penulis extends Model
{
    use HasFactory;

    protected $fillable = ['nama_penulis'];
    protected $visible = ['nama_penulis'];
    public $timestamps = true;

    public function buku()
    {
        return $this->hasMany(buku::class, 'id_penulis');
    }
}

