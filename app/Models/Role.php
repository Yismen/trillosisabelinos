<?php

namespace App\Models;

use Spatie\Permission\Models\Role as ModelsRole;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends ModelsRole
{
    use HasFactory;

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn ($name) => ucwords($name),
            set: fn ($name) => ucwords($name),
        );
    }
}
