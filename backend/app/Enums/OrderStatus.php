<?php

namespace App\Enums;

enum OrderStatus: String
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Preparing = 'preparing';
    case Completed = 'completed';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
}
