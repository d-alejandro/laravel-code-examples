<?php

namespace App\Enums;

enum OrderSortColumn: string
{
    case Id = 'id';
    case RentalDate = 'rental_date';
    case IsConfirmed = 'is_confirmed';
    case IsChecked = 'is_checked';
    case Status = 'status';
    case UserName = 'user_name';
    case AdminNote = 'admin_note';
}
