<?php

namespace App\DTO\AdminPanel\Order;

use App\DTO\BaseDTO;

class IndexOrderRequestDTO extends BaseDTO
{
    public const START = '_start';
    public const END = '_end';
    public const SORT = '_sort';
    public const ORDER = '_order';
    public const IDS = 'id';
    public const DATE_TOUR = 'date_tour';
    public const IS_CONFIRMED = 'is_confirmed';
    public const IS_CHECKED = 'is_checked';
    public const STATUS = 'status';
    public const NAME = 'name';
    public const AGENCY_NAME = 'agency_name';
    public const ADMIN_NOTE = 'admin_note';
    public const START_DATE = 'start_date';
    public const END_DATE = 'end_date';
    public const HAS_PHOTO_REPORT = 'has_photo_report';

    private int $start;
    private int $end;
    private string $sort;
    private string $order;
    private ?array $ids = null;
    private ?string $dateTour = null;
    private ?bool $isConfirmed = null;
    private ?bool $isChecked = null;
    private ?string $status = null;
    private ?string $name = null;
    private ?string $agencyName = null;
    private ?bool $adminNote = null;
    private ?string $startDate = null;
    private ?string $endDate = null;
    private ?bool $hasPhotoReport = null;

    protected function setters(): array
    {
        return [
            self::START => fn($value) => $this->start = $value,
            self::END => fn($value) => $this->end = $value,
            self::SORT => fn($value) => $this->sort = $value,
            self::ORDER => fn($value) => $this->order = $value,
            self::IDS => fn($value) => $this->ids = $value,
            self::DATE_TOUR => fn($value) => $this->dateTour = $value,
            self::IS_CONFIRMED => fn($value) => $this->isConfirmed = $value,
            self::IS_CHECKED => fn($value) => $this->isChecked = $value,
            self::STATUS => fn($value) => $this->status = $value,
            self::NAME => fn($value) => $this->name = $value,
            self::AGENCY_NAME => fn($value) => $this->agencyName = $value,
            self::ADMIN_NOTE => fn($value) => $this->adminNote = $value,
            self::START_DATE => fn($value) => $this->startDate = $value,
            self::END_DATE => fn($value) => $this->endDate = $value,
            self::HAS_PHOTO_REPORT => fn($value) => $this->hasPhotoReport = $value,
        ];
    }

    protected function getters(): array
    {
        return [
            self::START => $this->start,
            self::END => $this->end,
            self::SORT => $this->sort,
            self::ORDER => $this->order,
            self::IDS => $this->ids,
            self::DATE_TOUR => $this->dateTour,
            self::IS_CONFIRMED => $this->isConfirmed,
            self::IS_CHECKED => $this->isChecked,
            self::STATUS => $this->status,
            self::NAME => $this->name,
            self::AGENCY_NAME => $this->agencyName,
            self::ADMIN_NOTE => $this->adminNote,
            self::START_DATE => $this->startDate,
            self::END_DATE => $this->endDate,
            self::HAS_PHOTO_REPORT => $this->hasPhotoReport,
        ];
    }
}
