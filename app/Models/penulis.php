<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penulis extends Model
{
    use HasFactory;
    public $fillable = ['nama_penulis'];
    public $visible = ['nama_penulis'];
    public $timestamps = true;

    public function penulis()
    {
        return $this->hasMany(penulis::class, 'id_penulis');
    }
}
