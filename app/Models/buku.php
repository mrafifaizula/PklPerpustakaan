<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buku extends Model
{
    use HasFactory;
    public $fillable = ['judul', 'tahun_terbit', 'jumlah_buku', 'desc_buku'];
    public $visible = ['judul', 'tahun_terbit', 'jumlah_buku', 'desc_buku'];
    public $timestamps = true;

    public function deleteImage()
    {
        $imagePath = public_path('images/buku/' . $this->image_buku);

        if ($this->image_buku && file_exists($imagePath)) {
            return unlink($imagePath); // Deletes the file
        }

        return false;
    }

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'id_kategori');

    }

    public function penulis()
    {
        return $this->belongsTo(penulis::class, 'id_penulis');

    }

    public function penerbit()
    {
        return $this->belongsTo(penerbit::class, 'id_penerbit');

    }

}
