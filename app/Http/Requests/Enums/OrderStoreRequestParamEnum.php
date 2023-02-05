<?php

namespace App\Http\Requests\Enums;

use App\Http\Requests\Enums\Interfaces\RequestParamEnumInterface;

enum OrderStoreRequestParamEnum: string implements RequestParamEnumInterface
{
    case AgencyName = 'agency_name';
    case RentalDate = 'rental_date';
    case GuestCount = 'guest_count';
    case TransportCount = 'transport_count';
    case UserName = 'user_name';
    case Email = 'email';
    case Phone = 'phone';
    case Note = 'note';
    case AdminNote = 'admin_note';
}
