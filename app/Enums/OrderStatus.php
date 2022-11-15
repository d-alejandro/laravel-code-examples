<?php

namespace App\Enums;

enum OrderStatus
{
    case Canceled;
    case Completed;
    case Paid;
    case Prepayment;
    case Waiting;
}
