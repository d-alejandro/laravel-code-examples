<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Models\Enums\OrderColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Agency agency
 */
final class Order extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = 'orders';
    public const RELATION_AGENCY = 'agency';

    protected $guarded = [
        OrderColumn::Id->value,
    ];

    protected $attributes = [
        OrderColumn::Status->value => OrderStatusEnum::Waiting,
        OrderColumn::IsChecked->value => false,
        OrderColumn::IsConfirmed->value => false,
    ];

    protected $dates = [
        OrderColumn::RentalDate->value,
        OrderColumn::ConfirmedAt->value,
    ];

    protected $casts = [
        OrderColumn::Status->value => OrderStatusEnum::class,
    ];

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function getAgency(): Agency
    {
        return $this->agency;
    }

    public function setAgency(Agency $agency): void
    {
        $this->agency()->associate($agency);
    }
}
