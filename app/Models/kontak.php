<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kontak extends Model
{
    use HasFactory;
    public $fillable = ['pesan'];
    public $visible = ['pesan'];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(user::class, 'id_user');

    }
}
