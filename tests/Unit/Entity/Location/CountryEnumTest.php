<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity\Location;

use App\Entity\Location\LocationCountryEnum;
use PHPUnit\Framework\TestCase;

class CountryEnumTest extends TestCase
{
    public function testCallStatic(): void
    {
        $this->assertTrue(LocationCountryEnum::GERMANY()->value === 'Germany');
        $this->assertTrue(LocationCountryEnum::POLAND()->value === 'Poland');
    }
}
