<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'source',
    'status',
    'products_created',
    'products_updated',
    'products_skipped',
    'message',
    'context',
    'started_at',
    'finished_at',
])]
#[Casts([
    'context' => 'array',
    'started_at' => 'datetime',
    'finished_at' => 'datetime',
])]
class ImportLog extends Model
{
    use HasFactory;
}
