<?php

namespace App\Models;

use App\Models\Event;
use App\Enums\RegistrationStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    public $fillable = ['name', 'event_id', 'phone', 'email', 'group', 'additional_phone', 'amount', 'amount_paid', 'amount_pending', 'status'];

    public $casts = [
        'enum' => RegistrationStatusEnum::class,
    ];

    use SoftDeletes;
    protected static function booted(): void
    {
        static::saved(function (Model $model) {
            $model->updateQuietly([
                'amount_pending' => $model->amount - $model->amount_paid,
            ]);
            $model->updateQuietly([
                'status' => $model->amount_pending > 0 ? RegistrationStatusEnum::Pending->value : RegistrationStatusEnum::Paid->value,
            ]);
            
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

    
}
