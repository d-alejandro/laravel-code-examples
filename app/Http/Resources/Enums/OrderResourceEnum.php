<?php

namespace App\Http\Resources\Enums;

enum OrderResourceEnum: string
{
    case Id = 'id';
    case AgencyName = 'agency_name';
    case Status = 'status';
    case RentalDate = 'rental_date';
    case GuestCount = 'guest_count';
    case TransportCount = 'transport_count';
    case UserName = 'user_name';
    case Email = 'email';
    case Phone = 'phone';
    case Note = 'note';
    case AdminNote = 'admin_note';
    case IsConfirmed = 'is_confirmed';
    case IsChecked = 'is_checked';
    case CreatedAt = 'created_at';
    case UpdatedAt = 'updated_at';
}
