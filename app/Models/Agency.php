<?php

namespace App\Models;

use App\Models\Enums\AgencyColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Agency extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = 'agencies';

    protected $guarded = [
        AgencyColumn::Id->value,
    ];
}
