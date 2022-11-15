<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Order extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = 'orders';

    public const COLUMN_ID = 'id';
    public const COLUMN_AGENCY_ID = 'agency_id';
    public const COLUMN_STATUS = 'status';
    public const COLUMN_IS_CHECKED = 'is_checked';
    public const COLUMN_IS_CONFIRMED = 'is_confirmed';
    public const COLUMN_RENTAL_DATE = 'rental_date';
    public const COLUMN_GUESTS_COUNT = 'guests_count';
    public const COLUMN_TRANSPORT_COUNT = 'transport_count';
    public const COLUMN_USER_NAME = 'user_name';
    public const COLUMN_EMAIL = 'email';
    public const COLUMN_PHONE = 'phone';
    public const COLUMN_NOTE = 'note';
    public const COLUMN_ADMIN_NOTE = 'admin_note';
    public const COLUMN_CONFIRMED_AT = 'confirmed_at';
    public const COLUMN_CREATED_AT = 'created_at';
    public const COLUMN_UPDATED_AT = 'updated_at';

    public const RELATION_AGENCY = 'agency';

    protected $guarded = [
        self::COLUMN_ID,
    ];

    protected $attributes = [
        self::COLUMN_STATUS => OrderStatus::Waiting,
        self::COLUMN_IS_CHECKED => false,
        self::COLUMN_IS_CONFIRMED => false,
    ];

    protected $dates = [
        self::COLUMN_RENTAL_DATE,
        self::COLUMN_CONFIRMED_AT,
    ];
}
