<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        // 'meta_title',
        // 'meta_description',
        // 'meta_keywords',
        // 'schema'
    ];
   
    public function posts()
    {
        return $this->belongsToMany(Post::class,'posts_tags','tag_id','post_id');
    }
    public function seo()
    {
        return $this->hasOne(Seo::class);
    }
}
