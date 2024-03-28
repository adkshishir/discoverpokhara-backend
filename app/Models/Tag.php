<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
    ];
   
    public function posts()
    {
        return $this->belongsToMany(Post::class,'tag_posts','tag_id','post_id');
    }
    public function seo()
    {
        return $this->hasOne(Seo::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getImageUrlAttribute()
    {
        return $this->getFile();
    }
}
