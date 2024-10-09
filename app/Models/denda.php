<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class denda extends Model
{
    use HasFactory;

    protected $fillable = ['jumlah_denda', 'jenis_denda', 'status_dibayar'];
    protected $visible = ['jumlah_denda', 'jenis_denda', 'status_dibayar'];
    public $timestamps = true;

    public function pinjambuku()
    {
        return $this->belongsTo(pinjambuku::class, 'id_pinjambuku');
    }
}
