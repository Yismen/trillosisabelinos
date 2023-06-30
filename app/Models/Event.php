<?php

namespace App\Models;

use App\Enums\EventStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use \App\Models\Traits\MorphManyImages;
    public $fillable = ['name', 'date', 'status'];

    public $casts = [
        'status' => EventStatusEnum::class,
        'date' => 'date',
    ];
    use HasFactory;
    use SoftDeletes;

    public function scopeAvailable(Builder $builder)
    {
        return $builder->whereIn('status', [
            EventStatusEnum::Pending->value, EventStatusEnum::Open->value
        ]);
    }
}
