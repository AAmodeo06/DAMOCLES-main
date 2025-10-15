<?php

//REALIZZATO DA: Andrea Amodeo

namespace App\Enums;

enum DebtLevel: string {
    case NONE = 'none';
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case MAX = 'max';


    public static function labels(): array {
        return [
            self::NONE->value =>'Nessuno',
            self::LOW->value => 'Basso',
            self::MEDIUM->value => 'Medio',
            self::HIGH->value => 'Alto',
            self::MAX->value => 'Massimo',
        ];
    }
}
