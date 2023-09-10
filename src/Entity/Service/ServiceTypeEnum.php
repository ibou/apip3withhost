<?php

declare(strict_types=1);

namespace App\Entity\Service;

/**
 * @method static self CSGO()
 */
enum ServiceTypeEnum: string
{
    case TYPE_CSGO = 'csgo';

    public static function __callStatic($name, $arguments): self
    {
        /**
         * @todo When adding more types, create logic responsible for creating them
         */
        assert($name === 'CSGO');
        return ServiceTypeEnum::TYPE_CSGO;
    }
}
