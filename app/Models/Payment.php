<?php

namespace App\Models;

use App\Casts\AsMoney;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\InvalidPaymentAmount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    public $fillable = ['registration_id', 'amount', 'date', 'description', 'images'];

    public $casts = [
        'date' => 'date',
        'images' => 'array',
        'amount' => AsMoney::class
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    protected static function booted(): void
    {
        static::saved(function (Model $model) {
            $model->registration->updateAmounts();
        });
    }
}
