<?php

namespace App\Models;

use App\Models\Event;
use App\Enums\RegistrationStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    public $fillable = ['name', 'event_id', 'phone', 'email', 'group', 'additional_phone', 'amount'];

    public $casts = [
        'enum' => RegistrationStatusEnum::class,
    ];

    use SoftDeletes;

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    protected static function booted(): void
    {
        static::saved(function (Model $model) {
            $model->updateQuietly([
                'status' => $model->amount_pending > 0 ? RegistrationStatusEnum::Pending->value : RegistrationStatusEnum::Paid->value,
            ]);
            
        });
    }

    
}
