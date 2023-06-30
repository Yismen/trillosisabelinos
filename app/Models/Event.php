<?php

namespace App\Models;

use App\Enums\EventStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    public $fillable = ['name', 'date', 'status', 'images'];

    public $casts = [
        'status' => EventStatusEnum::class,
        'date' => 'date',
        'images' => 'array',
    ];
    use HasFactory;
    use SoftDeletes;

    public function scopeAvailable(Builder $builder)
    {
        return $builder->where('status', EventStatusEnum::Open->value);
    }
    protected static function booted(): void
    {
        static::saved(function (Model $model) {
            $status = $model->date >= now() ? EventStatusEnum::Closed : EventStatusEnum::Open;

            $model->updateQuietly([
                'status' => $status,
            ]);
            
        });
    }
}
