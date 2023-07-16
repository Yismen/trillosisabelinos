<?php

namespace App\Models;

use App\Casts\AsMoney;
use App\Casts\AsHeadline;
use App\Enums\RegistrationStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $fillable = ['name', 'event_id', 'phone', 'email', 'group', 'additional_phone', 'amount', 'amount_paid', 'amount_pending', 'status'];

    public $casts = [
        'enum' => RegistrationStatusEnum::class,
        'amount' => AsMoney::class,
        'amount_paid' => AsMoney::class,
        'amount_pending' => AsMoney::class,
        'name' => AsHeadline::class,
    ];

    protected static function booted(): void
    {
        static::saving(function (Model $model) {
            $model->updateAmounts();
        });

        static::deleting(function (Model $model) {
            $model->payments->each->delete();
            $model->sales->each->delete();
        });

        static::restored(function (Model $model) {
            $model->sales()->withTrashed()->get()->each->restore();
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function phone(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => str($value)->replace(["-", " ", "(", ")"], ""),
            set: fn ($value) => str($value)->replace(["-", " ", "(", ")"], ""),
        );
    }

    public function updateAmounts()
    {
        $model = $this->load(['sales', 'payments.sales']);

        $amount = $model->sales->sum('amount');
        $amount_paid = $model->payments->sum('amount');
        $amount_pending = $amount - $amount_paid;

        $model->updateQuietly([
            'amount' => $amount,
            'amount_paid' => $amount_paid > $amount ? $amount : $amount_paid,
            'amount_pending' => $amount_pending < 0 ? 0 : $amount_pending,
            'status' => $amount_pending > 0 ? RegistrationStatusEnum::Pending : RegistrationStatusEnum::Paid,
        ]);
    }
}
