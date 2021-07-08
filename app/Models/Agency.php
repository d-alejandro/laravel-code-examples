<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Agency extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = 'agencies';

    public const COLUMN_ID = 'id';
    public const COLUMN_NAME = 'name';
    public const COLUMN_CONTACT = 'contact';

    protected $guarded = [
        self::COLUMN_ID,
    ];

    public function getters(): array
    {
        return [
            self::COLUMN_NAME => fn(): string => $this->getAttribute(self::COLUMN_NAME),
            self::COLUMN_CONTACT => fn(): ?string => $this->getAttribute(self::COLUMN_CONTACT),
        ];
    }

    public function setters(): array
    {
        return [
            self::COLUMN_NAME => fn(string $value) => $this->setAttribute(self::COLUMN_NAME, $value),
            self::COLUMN_CONTACT => fn(?string $value) => $this->setAttribute(self::COLUMN_CONTACT, $value),
        ];
    }
}
