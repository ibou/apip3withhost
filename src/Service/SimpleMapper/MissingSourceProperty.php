<?php

declare(strict_types=1);

namespace App\Service\SimpleMapper;

class MissingSourceProperty extends \Exception
{
    public function __construct(string $targetPropertyName, string $sourceClass, string $targetClass)
    {
        parent::__construct(sprintf(
            'Missing [%s] property or getter when mapping source [%s] to target [%s]',
            $targetPropertyName,
            $sourceClass,
            $targetClass,
        ));
    }
}