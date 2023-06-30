<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['plan_id', 'registration_id', 'count', 'unit_price', 'amount'];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
    protected static function booted(): void
    {
        static::saved(function (Model $model) {
            $model->updateQuietly([
                'amount' => $model->count * $model->unit_price,
            ]);
            
        });
    }
}
