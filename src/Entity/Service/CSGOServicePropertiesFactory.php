<?php

declare(strict_types=1);

namespace App\Entity\Service;

class CSGOServicePropertiesFactory implements ServicePropertiesFactoryInterface
{
    public function createFromArray(array $properties): CSGOServiceProperties
    {
        return new CSGOServiceProperties(
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