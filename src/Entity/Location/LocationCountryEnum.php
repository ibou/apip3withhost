<?php

declare(strict_types=1);

namespace App\Entity\Location;

/**
 * @method static self POLAND()
 * @method static self GERMANY()
 */
enum LocationCountryEnum: string
{
    case COUNTRY_POLAND = 'Poland';
    case COUNTRY_GERMANY = 'Germany';

    public static function __callStatic($name, $arguments): self
    {
        return self::from(ucfirst(strtolower($name)));
    }
}
