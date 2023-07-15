<?php

namespace App\Models;

use App\Casts\AsMoney;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\InvalidPaymentAmount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Payment extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    public $fillable = ['registration_id', 'code', 'amount', 'date', 'description', 'images'];

    public $casts = [
        'date' => 'date',
        'images' => 'array',
        'amount' => AsMoney::class,
        'subscriptions' => 'array',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    protected static function booted(): void
    {
        static::saved(function (Model $model) {
            $model->registration->updateAmounts();
            $model->updateQuietly(['code' => $model->getCode()]);
        });
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    protected function getCode(): string
    {
        if ($this->code) {
            return $this->code;
        }

        $event_name = $this->registration->event->name;
        $split = explode(" ", $event_name, 2);
        $code = count($split) === 1
            ? str($split[0])->substr(0, 4)
            : implode("", [str($split[0])->substr(0, 2), str($split[1])->substr(0, 2)]);
        return str($code)->upper() . '-' . str($this->id)->padLeft(5, 0);
    }

    public function updateAmounts()
    {
        $model = $this->load(['sales']);
        $amount = $model->sales->sum('amount');

        $model->updateQuietly([
            'amount' => $amount,
        ]);
    }

    public function subscriptions(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->sales->map(fn ($sale) => ['name' => "{$sale->count}-{$sale->plan->name}-{$sale->unit_price}"])->pluck('name')->toArray(),
        );
    }
}
