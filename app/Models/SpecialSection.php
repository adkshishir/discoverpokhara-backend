<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialSection extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'url',
        'content_id',
    ];
    public function content(){
        return $this->belongsTo(Content::class);
    }
    public function getImageUrlAttribute()
    {
        return $this->getFile();
    }
}
