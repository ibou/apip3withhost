<?php

declare(strict_types=1);

namespace App\Entity\Location;

class DockerLocationPropertiesFactory implements LocationPropertiesFactoryInterface
{
    public function createFromArray(array $properties): DockerLocationProperties
    {
        return new DockerLocationProperties(
            $properties['host'] ?? null,
            $properties['port'] ?? null,
            $properties['socket'] ?? null,
            $properties['caFilePath'] ?? null,
            $properties['localCertPath'] ?? null,
            $properties['localPrivateKeyPath'] ?? null,
        );
    }
}