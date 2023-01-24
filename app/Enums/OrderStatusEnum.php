<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case Canceled = 'canceled';
    case Completed = 'completed';
    case Paid = 'paid';
    case Prepayment = 'prepayment';
    case Waiting = 'waiting';
}
