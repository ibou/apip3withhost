<?php

namespace App\Tests\Unit\Service\Mock;

class TargetClass
{
    public function __construct(
        public string $a,
        public string $b,
        public array $c,
        public string $d,
    ) {
    }
}