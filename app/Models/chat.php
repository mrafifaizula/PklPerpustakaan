<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }
    
    public static function getLatest($limit = 50)
    {
        return static::with('user')
            ->latest()
            ->take($limit)
            ->get();
    }
}
