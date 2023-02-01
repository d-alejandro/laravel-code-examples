<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Models\Enums\OrderColumn;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function getColumn(OrderColumn $column): mixed
    {
        $attribute = $this->getColumns()[$column->value];
        return ($attribute->get)();
    }

    public function setColumn(OrderColumn $column, mixed $value): void
    {
        $attribute = $this->getColumns()[$column->value];
        ($attribute->set)($value);
    }

    private function getColumns(): array
    {
        return [
            OrderColumn::Status->value => new Attribute(
                get: fn(): OrderStatusEnum => $this->getAttribute(OrderColumn::Status->value),
                set: fn(OrderStatusEnum $value) => $this->setAttribute(OrderColumn::Status->value, $value)
            ),
            OrderColumn::IsChecked->value => new Attribute(
                get: fn(): bool => $this->getAttribute(OrderColumn::IsChecked->value),
                set: fn(bool $value) => $this->setAttribute(OrderColumn::IsChecked->value, $value)
            ),
            OrderColumn::IsConfirmed->value => new Attribute(
                get: fn(): bool => $this->getAttribute(OrderColumn::IsConfirmed->value),
                set: fn(bool $value) => $this->setAttribute(OrderColumn::IsConfirmed->value, $value)
            ),
            OrderColumn::RentalDate->value => new Attribute(
                get: fn(): Carbon => $this->getAttribute(OrderColumn::RentalDate->value),
                set: fn(Carbon $value) => $this->setAttribute(OrderColumn::RentalDate->value, $value)
            ),
            OrderColumn::GuestsCount->value => new Attribute(
                get: fn(): int => $this->getAttribute(OrderColumn::GuestsCount->value),
                set: fn(int $value) => $this->setAttribute(OrderColumn::GuestsCount->value, $value)
            ),
            OrderColumn::TransportCount->value => new Attribute(
                get: fn(): int => $this->getAttribute(OrderColumn::TransportCount->value),
                set: fn(int $value) => $this->setAttribute(OrderColumn::TransportCount->value, $value)
            ),
            OrderColumn::UserName->value => new Attribute(
                get: fn(): string|null => $this->getAttribute(OrderColumn::UserName->value),
                set: fn(string|null $value) => $this->setAttribute(OrderColumn::UserName->value, $value)
            ),
            OrderColumn::Email->value => new Attribute(
                get: fn(): string => $this->getAttribute(OrderColumn::Email->value),
                set: fn(string $value) => $this->setAttribute(OrderColumn::Email->value, $value)
            ),
            OrderColumn::Phone->value => new Attribute(
                get: fn(): string => $this->getAttribute(OrderColumn::Phone->value),
                set: fn(string $value) => $this->setAttribute(OrderColumn::Phone->value, $value)
            ),
            OrderColumn::Note->value => new Attribute(
                get: fn(): string|null => $this->getAttribute(OrderColumn::Note->value),
                set: fn(string|null $value) => $this->setAttribute(OrderColumn::Note->value, $value)
            ),
            OrderColumn::AdminNote->value => new Attribute(
                get: fn(): string|null => $this->getAttribute(OrderColumn::AdminNote->value),
                set: fn(string|null $value) => $this->setAttribute(OrderColumn::AdminNote->value, $value)
            ),
            OrderColumn::ConfirmedAt->value => new Attribute(
                get: fn(): Carbon|null => $this->getAttribute(OrderColumn::ConfirmedAt->value),
                set: fn(Carbon|null $value) => $this->setAttribute(OrderColumn::ConfirmedAt->value, $value)
            ),
            OrderColumn::CreatedAt->value => new Attribute(
                get: fn(): Carbon|null => $this->getAttribute(OrderColumn::CreatedAt->value),
                set: fn(Carbon|null $value) => $this->setAttribute(OrderColumn::CreatedAt->value, $value)
            ),
            OrderColumn::UpdatedAt->value => new Attribute(
                get: fn(): Carbon|null => $this->getAttribute(OrderColumn::UpdatedAt->value),
                set: fn(Carbon|null $value) => $this->setAttribute(OrderColumn::UpdatedAt->value, $value)
            ),
            OrderColumn::DeletedAt->value => new Attribute(
                get: fn(): Carbon|null => $this->getAttribute(OrderColumn::DeletedAt->value),
                set: fn(Carbon|null $value) => $this->setAttribute(OrderColumn::DeletedAt->value, $value)
            ),
        ];
    }
}
