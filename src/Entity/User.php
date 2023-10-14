<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[
    ApiResource(
        operations: [],
        formats: ['json'],
        normalizationContext: ['user:read'],
        denormalizationContext: ['user:write'],
    ),
]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['user:read'])]
    private Uuid $uuid;

    #[ORM\Column(type: 'uuid')]
    private Uuid $authUuid;

    #[ORM\Column(length: 255, unique: true)]
    private string $steamId;

    #[ORM\Column]
    private array $privileges;

    public function __construct(
        Uuid  $uuid,
        Uuid  $authUuid,
        string $steamId,
        array $privileges,
    ) {
        $this->uuid = $uuid;
        $this->authUuid = $authUuid;
        $this->steamId = $steamId;
        $this->privileges = $privileges;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getSteamId(): string
    {
        return $this->steamId;
    }

    public function getRoles(): array
    {
        return $this->privileges;
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->authUuid;
    }
}
