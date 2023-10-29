<?php

declare(strict_types=1);

namespace App\Entity\Location;

interface LocationPropertiesFactoryInterface
{
    public function createFromArray(array $properties): LocationPropertiesInterface;
}