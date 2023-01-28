<?php

namespace App\Models\Enums;

enum AgencyEnum: string
{
    case Id = 'id';
    case Name = 'name';
    case Contact = 'contact';
    case CreatedAt = 'created_at';
    case UpdatedAt = 'updated_at';
    case DeletedAt = 'deleted_at';
}
