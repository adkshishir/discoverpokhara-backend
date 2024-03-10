<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'image',
        'author_id',
        'publication_date',
        'slug'
    ];
    // set publication date automatically

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
    public function categories()
    {
        return $this->belongsToMany(Category::class,'post_categories','category_id','post_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'posts_tags','tag_id','post_id');
    }

}
