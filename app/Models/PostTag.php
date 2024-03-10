<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    use HasFactory;
  protected $table = 'posts_tags';
  protected $fillable=[
    'post_id',
    'tag_id'
  ];

  public function posts()
  {
    return $this->hasMany(Post::class);
  }
  public function tags()
  {
    return $this->hasMany(Tag::class);
  }
    
}
