<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends BaseModel
{
    use HasFactory;
  protected $fillable = [
        'title',
        'content',
        'post_id'
    ];
    public function post(){
        return $this->belongsTo(Post::class);
    }
    public function special_sections(){
        return $this->hasMany(SpecialSection::class);
    }
}
