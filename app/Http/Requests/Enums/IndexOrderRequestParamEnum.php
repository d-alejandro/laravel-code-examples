<?php

namespace App\Http\Requests\Enums;

use App\Http\Requests\Enums\Interfaces\RequestParamEnumInterface;

enum IndexOrderRequestParamEnum: string implements RequestParamEnumInterface
{
    case RentalDate = 'rental_date';
    case IsConfirmed = 'is_confirmed';
    case IsChecked = 'is_checked';
    case Status = 'status';
    case UserName = 'user_name';
    case AgencyName = 'agency_name';
    case AdminNote = 'admin_note';
    case StartDate = 'start_date';
    case EndDate = 'end_date';
}
