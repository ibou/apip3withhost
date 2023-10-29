<?php

declare(strict_types=1);

namespace App\DataFixtures;

class AliceHelper
{
    public function randomValue(array $values): mixed
    {
        return $values[rand(0, count($values) - 1)];
    }
}