<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
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
    use CreatedUpdatedTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['user:read'])]
    private Uuid $uuid;

    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $authUuid;

    #[ORM\Column(length: 255, unique: true)]
    private string $steamId;

    #[ORM\Column]
    private array $privileges;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Service::class)]
    private Collection $services;

    public function __construct(
        string $steamId,
        array $privileges,
        Uuid $uuid = null,
        Uuid $authUuid = null,
    ) {
        $this->uuid = $uuid ?? Uuid::v7();
        $this->authUuid = $authUuid ?? Uuid::v7();

        $this->steamId = $steamId;
        $this->privileges = $privileges;
        $this->services = new ArrayCollection();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getAuthUuid(): Uuid
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

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->authUuid;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setOwner($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getOwner() === $this) {
                $service->setOwner(null);
            }
        }

        return $this;
    }
}
