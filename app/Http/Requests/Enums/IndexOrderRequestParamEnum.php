<?php

namespace App\Http\Requests\Enums;

use App\Enums\Interfaces\RequestParamEnumInterface;
use App\Models\Order;

enum IndexOrderRequestParamEnum: string implements RequestParamEnumInterface
{
    case RentalDate = Order::COLUMN_RENTAL_DATE;
    case IsConfirmed = Order::COLUMN_IS_CONFIRMED;
    case IsChecked = Order::COLUMN_IS_CHECKED;
    case Status = Order::COLUMN_STATUS;
    case UserName = Order::COLUMN_USER_NAME;
    case AgencyName = 'agency_name';
    case AdminNote = Order::COLUMN_ADMIN_NOTE;
    case StartDate = 'start_date';
    case EndDate = 'end_date';
}
