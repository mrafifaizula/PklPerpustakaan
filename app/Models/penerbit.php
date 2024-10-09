<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penerbit extends Model
{
    use HasFactory;

    protected $fillable = ['nama_penerbit'];
    protected $visible = ['nama_penerbit'];
    public $timestamps = true;

    public function buku()
    {
        return $this->hasMany(buku::class, 'id_penerbit');
    }
}
