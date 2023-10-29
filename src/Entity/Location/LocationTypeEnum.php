<?php

declare(strict_types=1);

namespace App\Entity\Location;

/**
 * @method static self DOCKER()
 */
enum LocationTypeEnum: string
{
    case TYPE_DOCKER = 'docker';

    public static function __callStatic($name, $arguments): self
    {
        return self::from(strtolower($name));
    }
}
