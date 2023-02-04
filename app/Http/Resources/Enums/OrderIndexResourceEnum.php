<?php

namespace App\Http\Resources\Enums;

enum OrderIndexResourceEnum: string
{
    case Id = 'id';
    case AgencyName = 'agency_name';
    case Status = 'status';
    case IsConfirmed = 'is_confirmed';
    case IsChecked = 'is_checked';
    case RentalDate = 'rental_date';
    case UserName = 'user_name';
    case TransportCount = 'transport_count';
    case GuestsCount = 'guests_count';
    case AdminNote = 'admin_note';
}
