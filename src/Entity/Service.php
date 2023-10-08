<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use App\Entity\Service\ServicePropertiesFactory;
use App\Entity\Service\ServiceStatusEnum;
use App\Entity\Service\ServiceTypeEnum;
use DateTimeImmutable;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Service\ServicePropertiesInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    formats: ['json'],
    normalizationContext: ['service:read'],
    denormalizationContext: ['service:write'],
)]
class Service
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)] 
    #[ORM\GeneratedValue(strategy: 'CUSTOM')] 
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups(['service:read'])]
    public ?Uuid $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(['service:read', 'service:write'])]
    private string $hostName;

    #[ORM\Column(type: Types::STRING, enumType: ServiceTypeEnum::class)]
    #[Groups(['service:read', 'service:write'])]
    private ServiceTypeEnum $type;

    #[ORM\Column(type: Types::STRING, enumType: ServiceStatusEnum::class)]
    #[ApiProperty(writable: false)]
    #[Groups(['service:read'])]
    private ServiceStatusEnum $status;

    #[ORM\Column]
    #[Groups(['service:write'])]
    #[ApiProperty(readable: false)]
    private array $properties = [];

    #[ORM\Column(length: 15, nullable: true)]
    #[Assert\Ip(version: '4')]
    #[Groups(['service:read'])]
    private ?string $ip = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThan(1023)]
    #[Assert\LessThan(65535)]
    #[Groups(['service:read'])]
    private ?int $port = null;

    #[Assert\Valid]
    #[ApiProperty(readable: true, writable: false)]
    #[Groups(['service:read'])]
    #[SerializedName('properties')]
    private ServicePropertiesInterface $serviceProperties;

    #[ApiProperty(writable: false)]
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups(['service:read'])]
    public DateTimeImmutable $createdAt;

    #[ApiProperty(writable: false)]
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups(['service:read'])]
    public DateTimeImmutable $updatedAt;

    public function __construct(
        string             $hostName,
        ServiceTypeEnum    $type,
        array              $properties,
        ?ServiceStatusEnum $status = null,
        ?string            $ip = null,
        ?int               $port = null,
    ) {
        $this->hostName = $hostName;
        $this->type = $type;
        $this->status = $status ?? ServiceStatusEnum::STATUS_CREATING;
        $this->properties = $properties;
        $this->serviceProperties = (new ServicePropertiesFactory)->createFromArray($type, $properties);
        $this->ip = $ip;
        $this->port = $port;
    }

    #[ORM\PrePersist]
    public function prePersist(): void 
    { 
        $this->createdAt = $this->createdAt ?? new DateTimeImmutable();
        $this->updatedAt = $this->createdAt; 
    }

    #[ORM\PostLoad]
    public function initServiceProperties(): void
    {
        $this->serviceProperties = (new ServicePropertiesFactory)->createFromArray($this->type, $this->properties);
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void 
    { 
        $this->updatedAt = new DateTimeImmutable(); 
    } 

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getHostName(): ?string
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
}
