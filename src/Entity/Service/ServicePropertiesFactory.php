<?php

declare(strict_types=1);

namespace App\Entity\Service;

class ServicePropertiesFactory
{
    private array $map = [
        ServiceTypeEnum::TYPE_CSGO->value => CS2ServicePropertiesFactory::class,
    ];

    public function createFromArray(ServiceTypeEnum $type, array $properties): ServicePropertiesInterface
    {
        $factory = $this->getFactory($type);
        return $factory->createFromArray($properties);
    }

    private function getFactory(ServiceTypeEnum $type): ServicePropertiesFactoryInterface
    {
        assert(array_key_exists($type->value, $this->map));

        return new $this->map[$type->value];
    }
}