<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashNew extends Model
{
    use HasFactory;
    protected $table = 'flash_news';

    protected $fillable = [
        'title',
        'link',
    ];
}
