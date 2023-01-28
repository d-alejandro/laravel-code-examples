<?php

namespace App\Models\Enums;

use App\Enums\Interfaces\ModelColumnInterface;

enum AgencyColumn: string implements ModelColumnInterface
{
    case Id = 'id';
    case Name = 'name';
    case Contact = 'contact';
    case CreatedAt = 'created_at';
    case UpdatedAt = 'updated_at';
    case DeletedAt = 'deleted_at';
}
