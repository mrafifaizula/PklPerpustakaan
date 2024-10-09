<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testimoni extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'id_pinjambuku', 'id_buku', 'testimoni', 'penilaian'];
    protected $visible = ['testimoni', 'penilaian'];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(user::class, 'id_user');
    }

    public function pinjambuku()
    {
        return $this->belongsTo(pinjambuku::class, 'id_pinjambuku');
    }

    public function buku()
    {
        return $this->belongsTo(buku::class, 'id_buku');
    }
}
