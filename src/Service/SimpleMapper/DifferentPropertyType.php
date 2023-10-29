<?php

declare(strict_types=1);

namespace App\Service\SimpleMapper;

class DifferentPropertyType extends \Exception
{
    public function __construct(string $targetPropertyName, string $sourceClass, string $targetClass)
    {
        parent::__construct(sprintf(
            'Target property [%s] has incompatible type when mapping source [%s] to target [%s]',
            $targetPropertyName,
            $sourceClass,
            $targetClass,
        ));
    }
}