<?php

declare(strict_types=1);

namespace App\ApiResource;

trait ServiceStatusEnumTrait
{
    public function getId(): string
    {
        return $this->name;
    }

    public static function getCases(): array
    {
        $out = [];
        foreach (self::cases() as $case)
        {
            $out[] = $case->value;
        }
        return $out;
    }

    public static function __callStatic($name, $arguments): self
    {
        return self::from(strtolower($name));
    }
}