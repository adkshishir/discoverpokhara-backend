<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'bio',
        'avatar',
        'user_id'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
