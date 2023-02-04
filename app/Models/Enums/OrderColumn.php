<?php

namespace App\Models\Enums;

use App\Models\Enums\Interfaces\ModelColumnInterface;

enum OrderColumn: string implements ModelColumnInterface
{
    case Id = 'id';
    case AgencyId = 'agency_id';
    case Status = 'status';
    case IsChecked = 'is_checked';
    case IsConfirmed = 'is_confirmed';
    case RentalDate = 'rental_date';
    case GuestCount = 'guest_count';
    case TransportCount = 'transport_count';
    case UserName = 'user_name';
    case Email = 'email';
    case Phone = 'phone';
    case Note = 'note';
    case AdminNote = 'admin_note';
    case ConfirmedAt = 'confirmed_at';
    case CreatedAt = 'created_at';
    case UpdatedAt = 'updated_at';
    case DeletedAt = 'deleted_at';
}
