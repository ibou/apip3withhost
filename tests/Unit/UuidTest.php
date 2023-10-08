<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class UuidTest extends TestCase
{
    public function testFromString(): void
    {
        $id = Uuid::fromString('bc75114d-8f66-4cf5-98ec-13e608ac088c');

        $this->assertEquals('QGkMujdxpfojx1jrAJsEcB', $id->toBase58());
        $this->assertEquals('5WEM8MV3V69KTSHV0KWR4AR24C', $id->toBase32());
    }
}