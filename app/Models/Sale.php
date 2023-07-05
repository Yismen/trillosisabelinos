<?php

namespace App\Models;

use App\Casts\AsMoney;
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

    protected $casts = [
        'unit_price' => AsMoney::class,
        'amount' => AsMoney::class,
    ];

    protected static function booted(): void
    {        
        static::saved(function (Model $model) {
            
            $model->updateQuietly([
                'amount' => $model->count * AsMoney::parse($model->plan->price) *  100
            ]);
            
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
            // get: fn (float $amount) => dd($amo),
            set: fn (float $amount) => $this->count * AsMoney::parse($this->unit_price) *  100,
        );
    }
}
