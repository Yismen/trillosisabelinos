<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait MorphManyImages
{

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
