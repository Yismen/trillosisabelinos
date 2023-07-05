<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['plan_id', 'registration_id', 'count', 'unit_price', 'amount'];

    protected static function booted(): void
    {
        static::saved(function (Model $model) {
            $model->registration->updateAmounts();
        });
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn (float $amount) => $this->count * $this->unit_price,
            set: fn (float $amount) => $this->count * $this->unit_price,
        );
    }
}
