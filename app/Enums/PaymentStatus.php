<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';

    case Settlement = 'settlement';

    case Expire = 'expire';

    case Cancel = 'cancel';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Settlement => 'Settlement',
            self::Expire => 'Expired',
            self::Cancel => 'Cancelled',
        };
    }
}
