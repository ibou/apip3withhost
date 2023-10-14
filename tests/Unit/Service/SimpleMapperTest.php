<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Service\SimpleMapper;
use App\Tests\Unit\Service\Mock\Source;
use App\Tests\Unit\Service\Mock\TargetClass;
use Faker\Container\ContainerBuilder;
use PHPUnit\Framework\TestCase;

class SimpleMapperTest extends TestCase
{
    public function testMapToEntity(): void
    {
        $source = new Source();

        $containerBuilder = new ContainerBuilder();
        $container = $containerBuilder->build();

        $mapper = new SimpleMapper($container);
        $entity = $mapper->mapToEntity($source, TargetClass::class);

        $this->assertInstanceOf(TargetClass::class, $entity);
        $this->assertEqualsCanonicalizing(get_object_vars($source), get_object_vars($entity));
    }

    public function testMapToResourceApi(): void
    {
        $source = new TargetClass(
            'aa',
            'bb',
            [
                1,2,3
            ],
            'dd'
        );

        $containerBuilder = new ContainerBuilder();
        $container = $containerBuilder->build();

        $mapper = new SimpleMapper($container);
        $resourceApi = $mapper->mapToResourceApi($source, Source::class);

        $this->assertInstanceOf(Source::class, $resourceApi);
        $this->assertTrue($resourceApi->a === 'aa');
        $this->assertTrue($resourceApi->b === 'bb');
        $this->assertTrue($resourceApi->c === [ 1,2,3 ]);
        $this->assertTrue($resourceApi->d === 'dd');
    }
}