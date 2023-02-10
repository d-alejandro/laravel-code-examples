<?php

namespace App\Http\Requests\Enums;

use App\Http\Requests\Enums\Interfaces\RequestParamEnumInterface;

enum OrderUpdateRequestParamEnum: string implements RequestParamEnumInterface
{
    case GuestCount = 'guest_count';
    case TransportCount = 'transport_count';
    case UserName = 'user_name';
    case Email = 'email';
    case Phone = 'phone';
    case Note = 'note';
    case AdminNote = 'admin_note';
}
