<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'tag_id',
        'post_id',
        'seo_type',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'schema',
        'cannonical_url',
        'og_title',
        'og_description',
        'og_image',
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function tag(){
        return $this->belongsTo(Tag::class);
    }
    public function getImageUrlAttribute()
    {
        return $this->getFile();
    }
}
