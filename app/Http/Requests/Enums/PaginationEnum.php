<?php

namespace App\Http\Requests\Enums;

use App\Enums\Interfaces\RequestParamEnumInterface;

enum PaginationEnum: string implements RequestParamEnumInterface
{
    case Start = 'start';
    case End = 'end';
    case SortColumn = 'sort_column';
    case SortType = 'sort_type';
    case Ids = 'id';
}
