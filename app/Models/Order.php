<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Agency agency
 * @method static int count(string $columns = '*')
 */
final class Order extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = 'orders';

    public const COLUMN_ID = 'id';
    public const COLUMN_AGENCY_ID = 'agency_id';
    public const COLUMN_STATUS = 'status';
    public const COLUMN_IS_CHECKED = 'is_checked';
    public const COLUMN_IS_CONFIRMED = 'is_confirmed';
    public const COLUMN_DATE_TOUR = 'date_tour';
    public const COLUMN_GUESTS_COUNT = 'guests_count';
    public const COLUMN_SCOOTERS_COUNT = 'scooters_count';
    public const COLUMN_TRANSFER = 'transfer';
    public const COLUMN_HOTEL = 'hotel';
    public const COLUMN_ROOM_NUMBER = 'room_number';
    public const COLUMN_NAME = 'name';
    public const COLUMN_EMAIL = 'email';
    public const COLUMN_GENDER = 'gender';
    public const COLUMN_NATIONALITY = 'nationality';
    public const COLUMN_PHONE = 'phone';
    public const COLUMN_IS_SUBSCRIBE = 'is_subscribe';
    public const COLUMN_NOTE = 'note';
    public const COLUMN_ADMIN_NOTE = 'admin_note';
    public const COLUMN_PHOTO_REPORT = 'photo_report';
    public const COLUMN_REFERRER = 'referrer';
    public const COLUMN_CONFIRMED_AT = 'confirmed_at';
    public const COLUMN_CREATED_AT = 'created_at';
    public const COLUMN_UPDATED_AT = 'updated_at';

    public const STATUS_CANCELED = 'canceled';
    public const STATUS_WAITING = 'waiting';
    public const STATUS_PAID = 'paid';
    public const STATUS_PREPAYMENT = 'prepayment';
    public const STATUS_COMPLETED = 'completed';

    public const RELATION_AGENCY = 'agency';

    protected $guarded = [
        self::COLUMN_ID,
    ];

    protected $attributes = [
        self::COLUMN_STATUS => self::STATUS_WAITING,
        self::COLUMN_IS_CHECKED => false,
        self::COLUMN_IS_CONFIRMED => false,
    ];

    protected $dates = [
        self::COLUMN_DATE_TOUR,
        self::COLUMN_CONFIRMED_AT,
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_CANCELED,
            self::STATUS_WAITING,
            self::STATUS_PAID,
            self::STATUS_PREPAYMENT,
            self::STATUS_COMPLETED,
        ];
    }

    public static function sortColumns(): array
    {
        return [
            self::COLUMN_ID,
            self::COLUMN_DATE_TOUR,
            self::COLUMN_IS_CONFIRMED,
            self::COLUMN_IS_CHECKED,
            self::COLUMN_STATUS,
            self::COLUMN_NAME,
            self::COLUMN_ADMIN_NOTE,
        ];
    }

    public function getters(): array
    {
        return [
            self::COLUMN_STATUS => fn(): string => $this->getAttribute(self::COLUMN_STATUS),
            self::COLUMN_IS_CHECKED => fn(): bool => $this->getAttribute(self::COLUMN_IS_CHECKED),
            self::COLUMN_IS_CONFIRMED => fn(): bool => $this->getAttribute(self::COLUMN_IS_CONFIRMED),
            self::COLUMN_DATE_TOUR => fn(): ?Carbon => $this->getAttribute(self::COLUMN_DATE_TOUR),
            self::COLUMN_GUESTS_COUNT => fn(): int => $this->getAttribute(self::COLUMN_GUESTS_COUNT),
            self::COLUMN_SCOOTERS_COUNT => fn(): int => $this->getAttribute(self::COLUMN_SCOOTERS_COUNT),
            self::COLUMN_TRANSFER => fn(): ?string => $this->getAttribute(self::COLUMN_TRANSFER),
            self::COLUMN_HOTEL => fn(): string => $this->getAttribute(self::COLUMN_HOTEL),
            self::COLUMN_ROOM_NUMBER => fn(): string => $this->getAttribute(self::COLUMN_ROOM_NUMBER),
            self::COLUMN_NAME => fn(): string => $this->getAttribute(self::COLUMN_NAME),
            self::COLUMN_EMAIL => fn(): string => $this->getAttribute(self::COLUMN_EMAIL),
            self::COLUMN_GENDER => fn(): ?string => $this->getAttribute(self::COLUMN_GENDER),
            self::COLUMN_NATIONALITY => fn(): ?string => $this->getAttribute(self::COLUMN_NATIONALITY),
            self::COLUMN_PHONE => fn(): string => $this->getAttribute(self::COLUMN_PHONE),
            self::COLUMN_IS_SUBSCRIBE => fn(): bool => $this->getAttribute(self::COLUMN_IS_SUBSCRIBE),
            self::COLUMN_NOTE => fn(): ?string => $this->getAttribute(self::COLUMN_NOTE),
            self::COLUMN_ADMIN_NOTE => fn(): ?string => $this->getAttribute(self::COLUMN_ADMIN_NOTE),
            self::COLUMN_PHOTO_REPORT => fn(): ?string => $this->getAttribute(self::COLUMN_PHOTO_REPORT),
            self::COLUMN_REFERRER => fn(): ?string => $this->getAttribute(self::COLUMN_REFERRER),
            self::COLUMN_CONFIRMED_AT => fn(): ?Carbon => $this->getAttribute(self::COLUMN_CONFIRMED_AT),
            self::COLUMN_CREATED_AT => fn(): ?Carbon => $this->getAttribute(self::COLUMN_CREATED_AT),
            self::COLUMN_UPDATED_AT => fn(): ?Carbon => $this->getAttribute(self::COLUMN_UPDATED_AT),
        ];
    }

    public function setters(): array
    {
        return [
            self::COLUMN_STATUS => fn(string $value) => $this->setAttribute(self::COLUMN_STATUS, $value),
            self::COLUMN_IS_CHECKED => fn(bool $value) => $this->setAttribute(self::COLUMN_IS_CHECKED, $value),
            self::COLUMN_IS_CONFIRMED => fn(bool $value) => $this->setAttribute(self::COLUMN_IS_CONFIRMED, $value),
            self::COLUMN_DATE_TOUR => fn(?Carbon $value) => $this->setAttribute(self::COLUMN_DATE_TOUR, $value),
            self::COLUMN_GUESTS_COUNT => fn(int $value) => $this->setAttribute(self::COLUMN_GUESTS_COUNT, $value),
            self::COLUMN_SCOOTERS_COUNT => fn(int $value) => $this->setAttribute(self::COLUMN_SCOOTERS_COUNT, $value),
            self::COLUMN_TRANSFER => fn(?string $value) => $this->setAttribute(self::COLUMN_TRANSFER, $value),
            self::COLUMN_HOTEL => fn(string $value) => $this->setAttribute(self::COLUMN_HOTEL, $value),
            self::COLUMN_ROOM_NUMBER => fn(string $value) => $this->setAttribute(self::COLUMN_ROOM_NUMBER, $value),
            self::COLUMN_NAME => fn(string $value) => $this->setAttribute(self::COLUMN_NAME, $value),
            self::COLUMN_EMAIL => fn(string $value) => $this->setAttribute(self::COLUMN_EMAIL, $value),
            self::COLUMN_GENDER => fn(?string $value) => $this->setAttribute(self::COLUMN_GENDER, $value),
            self::COLUMN_NATIONALITY => fn(?string $value) => $this->setAttribute(self::COLUMN_NATIONALITY, $value),
            self::COLUMN_PHONE => fn(string $value) => $this->setAttribute(self::COLUMN_PHONE, $value),
            self::COLUMN_IS_SUBSCRIBE => fn(bool $value) => $this->setAttribute(self::COLUMN_IS_SUBSCRIBE, $value),
            self::COLUMN_NOTE => fn(?string $value) => $this->setAttribute(self::COLUMN_NOTE, $value),
            self::COLUMN_ADMIN_NOTE => fn(?string $value) => $this->setAttribute(self::COLUMN_ADMIN_NOTE, $value),
            self::COLUMN_PHOTO_REPORT => fn(?string $value) => $this->setAttribute(self::COLUMN_PHOTO_REPORT, $value),
            self::COLUMN_REFERRER => fn(?string $value) => $this->setAttribute(self::COLUMN_REFERRER, $value),
            self::COLUMN_CONFIRMED_AT => fn(?Carbon $value) => $this->setAttribute(self::COLUMN_CONFIRMED_AT, $value),
        ];
    }

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
