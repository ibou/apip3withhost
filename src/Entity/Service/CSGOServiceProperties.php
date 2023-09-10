<?php

declare(strict_types=1);

namespace App\Entity\Service;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[
    ApiResource(
        operations: [],
    )
]
class CSGOServiceProperties implements ServicePropertiesInterface
{
    #[Groups(['service:read'])]
    private int $slots;
    #[ApiProperty(readable: false)]
    private ?string $rconPassword;
    #[ApiProperty(readable: false)]
    private ?string $joinPassword;
    private string $mapGroup;
    private string $map;
    private int $tickrate;
    private bool $vac;

    public function __construct(
        int     $slots,
        ?string $rconPassword,
        ?string $joinPassword,
        string  $mapGroup,
        string  $map,
        int     $tickrate,
        bool    $vac,
    )
    {
        $this->slots = $slots;
        $this->rconPassword = $rconPassword;
        $this->joinPassword = $joinPassword;
        $this->mapGroup = $mapGroup;
        $this->map = $map;
        $this->tickrate = $tickrate;
        $this->vac = $vac;
    }

    public function getSlots(): int
    {
        return $this->slots;
    }

    public function getRconPassword(): ?string
    {
        return $this->rconPassword;
    }

    public function getJoinPassword(): ?string
    {
        return $this->joinPassword;
    }

    public function getMapGroup(): string
    {
        return $this->mapGroup;
    }

    public function getMap(): string
    {
        return $this->map;
    }

    public function getTickrate(): int
    {
        return $this->tickrate;
    }

    public function isVac(): bool
    {
        return $this->vac;
    }
}