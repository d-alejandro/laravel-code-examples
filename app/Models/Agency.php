<?php

namespace App\Models;

use App\Models\Enums\AgencyColumn;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function getColumn(AgencyColumn $column): mixed
    {
        $attribute = $this->getColumns()[$column->value];
        return ($attribute->get)();
    }

    public function setColumn(AgencyColumn $column, mixed $value): void
    {
        $attribute = $this->getColumns()[$column->value];
        ($attribute->set)($value);
    }

    private function getColumns(): array
    {
        return [
            AgencyColumn::Name->value => new Attribute(
                get: fn(): string => $this->getAttribute(AgencyColumn::Name->value),
                set: fn(string $value) => $this->setAttribute(AgencyColumn::Name->value, $value)
            ),
            AgencyColumn::Contact->value => new Attribute(
                get: fn(): string|null => $this->getAttribute(AgencyColumn::Contact->value),
                set: fn(string|null $value) => $this->setAttribute(AgencyColumn::Contact->value, $value)
            ),
            AgencyColumn::CreatedAt->value => new Attribute(
                get: fn(): Carbon|null => $this->getAttribute(AgencyColumn::CreatedAt->value),
                set: fn(Carbon|null $value) => $this->setAttribute(AgencyColumn::CreatedAt->value, $value)
            ),
            AgencyColumn::UpdatedAt->value => new Attribute(
                get: fn(): Carbon|null => $this->getAttribute(AgencyColumn::UpdatedAt->value),
                set: fn(Carbon|null $value) => $this->setAttribute(AgencyColumn::UpdatedAt->value, $value)
            ),
            AgencyColumn::DeletedAt->value => new Attribute(
                get: fn(): Carbon|null => $this->getAttribute(AgencyColumn::DeletedAt->value),
                set: fn(Carbon|null $value) => $this->setAttribute(AgencyColumn::DeletedAt->value, $value)
            ),
        ];
    }
}
