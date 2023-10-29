<?php

declare(strict_types=1);

namespace App\Entity\Location;

class LocationPropertiesFactory
{
    private array $map = [
        LocationTypeEnum::TYPE_DOCKER->value => DockerLocationPropertiesFactory::class,
    ];

    public function createFromArray(LocationTypeEnum $type, array $properties): LocationPropertiesInterface
    {
        $factory = $this->getFactory($type);
        return $factory->createFromArray($properties);
    }

    private function getFactory(LocationTypeEnum $type): LocationPropertiesFactoryInterface
    {
        assert(array_key_exists($type->value, $this->map));

        return new $this->map[$type->value];
    }
}