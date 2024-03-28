<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BaseModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function registerMediaConversions(Media $media =null): void
    {
        try {
            $this->addMediaConversion('thumb')
                ->width(160)
                ->height(160);

            $this->addMediaConversion('medium')
                ->width(320)
                ->height(320);
            $this->addMediaConversion('large')
                ->width(640)
                ->height(640);
        } catch (InvalidManipulation $e) {
        }
    }

    function getFile($collectionName = null)
    {
        if ($collectionName) {
            if (count($this->getMedia($collectionName)) == 0) return null;
            return $this->getFirstMediaUrl($collectionName ?? null);
        } else {
            if (count($this->getMedia()) == 0) return null;
            return $this->getFirstMediaUrl() ?? null;
        }
    }
}