<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'type', 'pesan', 'read'];
    protected $visible = ['id_user', 'type', 'pesan', 'read'];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(user::class, 'id_user');
    }

}
