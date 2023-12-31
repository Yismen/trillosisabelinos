<?php

namespace App\Models;

use App\Casts\AsMoney;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = ['name', 'price', 'event_id'];

    public $casts = [
        'price' => AsMoney::class
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
