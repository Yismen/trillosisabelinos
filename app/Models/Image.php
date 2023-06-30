<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Image extends Model
{
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
