<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'photo_path', 'caption'];

    // Relasi untuk likes
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'photo_id', 'user_id')->withTimestamps();
    }

    // Relasi untuk user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi untuk komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
