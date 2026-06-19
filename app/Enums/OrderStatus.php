<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';

    case Success = 'success';

    case Confirmed = 'confirmed';

    case Packed = 'packed';

    case Shipped = 'shipped';

    case Completed = 'completed';

    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Success => 'Success',
            self::Confirmed => 'Confirmed',
            self::Packed => 'Packed',
            self::Shipped => 'Shipped',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }
}
