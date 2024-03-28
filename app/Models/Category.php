<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];


    public function posts()
    {
        return $this->hasMany(Post::class,);
    }
    public function seo(){
        return $this->hasOne(Seo::class);
    }
    public function tags(){
        return $this->hasMany(Tag::class);
    }
    public function getImageUrlAttribute()
    {
        return $this->getFile();
    }
}
