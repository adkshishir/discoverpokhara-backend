<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author_id',
        'publication_date',
        'slug',
        'category_id',
    ];
    // set publication date automatically
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->getFile();
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_posts', 'post_id', 'tag_id');
    }
    public function seo(){
        return $this->hasOne(Seo::class);
    }
    public function contents(){
        return $this->hasMany(Content::class);
    }
    public function image(){
        return $this->hasOne(Image::class);
    }
}
