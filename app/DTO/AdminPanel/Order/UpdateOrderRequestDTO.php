<?php

namespace App\DTO\AdminPanel\Order;

use App\DTO\BaseDTO;

class UpdateOrderRequestDTO extends BaseDTO
{
    public const GUESTS_COUNT = 'guests_count';
    public const SCOOTERS_COUNT = 'scooters_count';
    public const TRANSFER = 'transfer';
    public const HOTEL = 'hotel';
    public const ROOM_NUMBER = 'room_number';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const GENDER = 'gender';
    public const NATIONALITY = 'nationality';
    public const PHONE = 'phone';
    public const IS_SUBSCRIBE = 'is_subscribe';
    public const NOTE = 'note';
    public const ADMIN_NOTE = 'admin_note';
    public const PHOTO_REPORT = 'photo_report';

    private int $guestsCount;
    private int $scootersCount;
    private ?string $transfer = null;
    private string $hotel;
    private string $roomNumber;
    private string $name;
    private string $email;
    private ?string $gender = null;
    private ?string $nationality = null;
    private string $phone;
    private bool $isSubscribe;
    private ?string $note = null;
    private ?string $adminNote = null;
    private ?string $photoReport = null;

    protected function setters(): array
    {
        return [
            self::GUESTS_COUNT => fn($value) => $this->guestsCount = $value,
            self::SCOOTERS_COUNT => fn($value) => $this->scootersCount = $value,
            self::TRANSFER => fn($value) => $this->transfer = $value,
            self::HOTEL => fn($value) => $this->hotel = $value,
            self::ROOM_NUMBER => fn($value) => $this->roomNumber = $value,
            self::NAME => fn($value) => $this->name = $value,
            self::EMAIL => fn($value) => $this->email = $value,
            self::GENDER => fn($value) => $this->gender = $value,
            self::NATIONALITY => fn($value) => $this->nationality = $value,
            self::PHONE => fn($value) => $this->phone = $value,
            self::IS_SUBSCRIBE => fn($value) => $this->isSubscribe = $value,
            self::NOTE => fn($value) => $this->note = $value,
            self::ADMIN_NOTE => fn($value) => $this->adminNote = $value,
            self::PHOTO_REPORT => fn($value) => $this->photoReport = $value,
        ];
    }

    protected function getters(): array
    {
        return [
            self::GUESTS_COUNT => $this->guestsCount,
            self::SCOOTERS_COUNT => $this->scootersCount,
            self::TRANSFER => $this->transfer,
            self::HOTEL => $this->hotel,
            self::ROOM_NUMBER => $this->roomNumber,
            self::NAME => $this->name,
            self::EMAIL => $this->email,
            self::GENDER => $this->gender,
            self::NATIONALITY => $this->nationality,
            self::PHONE => $this->phone,
            self::IS_SUBSCRIBE => $this->isSubscribe,
            self::NOTE => $this->note,
            self::ADMIN_NOTE => $this->adminNote,
            self::PHOTO_REPORT => $this->photoReport,
        ];
    }
}
