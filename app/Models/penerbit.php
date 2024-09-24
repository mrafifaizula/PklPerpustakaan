<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penerbit extends Model
{
    use HasFactory;
    public $fillable = ['nama_penerbit'];
    public $visible = ['nama_penerbit'];
    public $timestamps = true;

    public function penerbit()
    {
        return $this->hasMany(penerbit::class, 'id_penerbit');
    }
}
