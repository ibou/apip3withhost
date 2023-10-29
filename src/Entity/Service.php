<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Service\ServicePropertiesFactory;
use App\Entity\Service\ServiceStatusEnum;
use App\Entity\Service\ServiceTypeEnum;
use App\Repository\ServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Service\ServicePropertiesInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: '`service`')]
class Service
{
    use CreatedUpdatedTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $uuid;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $hostName;

    #[ORM\Column(type: Types::STRING, enumType: ServiceTypeEnum::class)]
    private ServiceTypeEnum $type;

    #[ORM\Column(type: Types::STRING, enumType: ServiceStatusEnum::class)]
    private ServiceStatusEnum $status;

    #[ORM\Column]
    #[Groups(['service:write'])]
    private array $properties;

    #[ORM\Column(length: 15, nullable: true)]
    #[Assert\Ip(version: '4')]
    private ?string $ip;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThan(1023)]
    #[Assert\LessThan(65535)]
    private ?int $port;

    #[Assert\Valid]
    private ServicePropertiesInterface $serviceProperties;

    #[ORM\ManyToOne(inversedBy: 'services', fetch: 'EAGER')]
    #[ORM\JoinColumn(referencedColumnName: "uuid", nullable: false)]
    private Location $location;

    #[ORM\ManyToOne(inversedBy: 'services', fetch: 'EAGER')]
    #[ORM\JoinColumn(referencedColumnName: "uuid", nullable: false)]
    private User $owner;

    public function __construct(
        string             $hostName,
        ServiceTypeEnum    $type,
        array              $properties,
        User               $owner,
        Location           $location,
        ?ServiceStatusEnum $status = null,
        ?string            $ip = null,
        ?int               $port = null,
        ?Uuid              $uuid = null,
    ) {
        $this->uuid = $uuid ?? Uuid::v7();

        $this->hostName = $hostName;
        $this->type = $type;

        $this->properties = $properties;
        $this->serviceProperties = (new ServicePropertiesFactory)->createFromArray($type, $properties);

        $this->owner = $owner;
        $this->location = $location;
        $this->status = $status ?? ServiceStatusEnum::STATUS_CREATING;
        $this->ip = $ip;
        $this->port = $port;
    }

    #[ORM\PostLoad]
    public function initServiceProperties(): void
    {
        $this->serviceProperties = (new ServicePropertiesFactory)->createFromArray($this->type, $this->properties);
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getHostName(): string
    {
        return $this->hostName;
    }

    public function getStatus(): ServiceStatusEnum
    {
        return $this->status;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function getServiceProperties(): ServicePropertiesInterface
    {
        return $this->serviceProperties;
    }

    public function getType(): ServiceTypeEnum
    {
        return $this->type;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }
}
