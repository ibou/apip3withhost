<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait CreatedUpdatedTrait
{
    #[ApiProperty(writable: false)]
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups(['all:read'])]
    public DateTimeImmutable $createdAt;

    #[ApiProperty(writable: false)]
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups(['all:read'])]
    public DateTimeImmutable $updatedAt;

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = $this->createdAt ?? new DateTimeImmutable();
        $this->updatedAt = $this->createdAt;
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}