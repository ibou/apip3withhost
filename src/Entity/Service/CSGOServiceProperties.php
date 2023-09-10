<?php

declare(strict_types=1);

use App\Entity\Service\ServicePropertiesInterface;

class CSGOServiceProperties implements ServicePropertiesInterface
{
    public function __construct(
        public readonly int $slots,
        public readonly ?string $rconPassword,
        public readonly ?string $joinPassword,
        public readonly string $mapGroup,
        public readonly string $map,
        public readonly int $tickrate,
        public readonly bool $vac,
    ) {
        
    }
}