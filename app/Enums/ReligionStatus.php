<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ReligionStatus: string implements HasLabel
{
    case Islam = 'Islam';
    case Katolik = 'Katolik';
    case Kristen = 'Kristen';
    case Hindu = 'Hindu';
    case Buddha = 'Buddha';
    case Khonghucu = 'Khonghucu';
    case Null = '-';
    
    public function getLabel(): ?string
    {
        return match ($this) {
            self::Islam => 'Islam',
            self::Katolik => 'Katolik',
            self::Kristen => 'Kristen',
            self::Hindu => 'Hindu',
            self::Buddha => 'Buddha',
            self::Khonghucu => 'Khonghucu',
            self::Null => '-',
        };
    }
}
