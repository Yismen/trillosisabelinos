<?php

namespace App\Models;

use App\Enums\EventStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    public $fillable = ['name', 'date', 'status'];

    public $casts = [
        'status' => EventStatusEnum::class,
        'date' => 'date',
    ];
    use HasFactory;
    use SoftDeletes;
}
