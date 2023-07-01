<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use App\Enums\EventStatusEnum;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            // ->generateSlugsOnUpdate('name')
            ->saveSlugsTo('slug');
    }
    public $fillable = ['name', 'date', 'status', 'images', 'features', 'currency', 'description'];

    public $casts = [
        'status' => EventStatusEnum::class,
        'date' => 'date',
        'images' => 'array',
        'features' => 'array',
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
            $status = $model->date >= now() ? EventStatusEnum::Open : EventStatusEnum::Open;

            $model->updateQuietly([
                'status' => $status,
            ]);
            
        });
    }

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
