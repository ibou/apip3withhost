<?php

declare(strict_types=1);

namespace App\Entity\Service;

class CS2ServicePropertiesFactory implements ServicePropertiesFactoryInterface
{
    public function createFromArray(array $properties): CS2ServiceProperties
    {
        return new CS2ServiceProperties(
            $properties['slots'],
            $properties['rconPassword'] ?? null,
            $properties['joinPassword'] ?? null,
            $properties['mapGroup'],
            $properties['map'],
            $properties['tickrate'],
            $properties['vac'],
        );
    }
}