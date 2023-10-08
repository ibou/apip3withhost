<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity\Service;

use App\Entity\Service\CS2ServiceProperties;
use App\Entity\Service\ServicePropertiesFactory;
use App\Entity\Service\ServiceTypeEnum;
use PHPUnit\Framework\TestCase;

class ServicePropertiesFactoryTest extends TestCase
{
    public function testCreateFromArray(): void
    {
        $factory = new ServicePropertiesFactory();
        $properties = $factory->createFromArray(
            ServiceTypeEnum::TYPE_CSGO,
            [
                'slots' => 12,
                'rconPassword' => '123456',
                'joinPassword' => '123456',
                'mapGroup' => 'mg_bomb',
                'map' => 'de_dust2',
                'tickrate' => 128,
                'vac' => true,
            ],
        );

        $this->assertInstanceOf(CS2ServiceProperties::class, $properties);
    }
}