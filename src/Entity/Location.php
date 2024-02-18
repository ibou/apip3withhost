<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Location\Exception\AbstractLocationException;
use App\Entity\Location\Exception\LocationPropertiesException;
use App\Entity\Location\LocationCountryEnum;
use App\Entity\Location\LocationPropertiesFactory;
use App\Entity\Location\LocationPropertiesInterface;
use App\Entity\Location\LocationTypeEnum;
use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: '`location`')]
class Location
{
    use CreatedUpdatedTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $uuid;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::STRING, enumType: LocationCountryEnum::class)]
    private LocationCountryEnum $country;

    #[ORM\Column(type: Types::STRING, enumType: LocationTypeEnum::class)]
    private LocationTypeEnum $type;

    #[ORM\Column]
    private array $properties;

    #[Assert\Valid]
    private LocationPropertiesInterface $locationProperties;

    #[ORM\Column]
    private int $available;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Service::class)]
    private Collection $services;

    public function __construct(
        string $name,
        LocationCountryEnum $country,
        LocationTypeEnum $type,
        iterable $properties = [],
        int $available = 0,
        ?Uuid $uuid = null,
    ) {
        $this->uuid = $uuid ?? Uuid::v7();

        if (is_object($properties) && method_exists($properties, 'getArrayCopy')) {
            $properties = $properties->getArrayCopy();
        }
        $this->properties = $properties;

        try {
            $this->locationProperties = (new LocationPropertiesFactory())->createFromArray($type, $properties);
        } catch (AbstractLocationException $exception) {
            throw new LocationPropertiesException('Location properties are invalid.', 0, $exception);
        }

        $this->name = $name;
        $this->country = $country;
        $this->type = $type;
        $this->available = $available;
        $this->services = new ArrayCollection();
    }

    #[ORM\PostLoad]
    public function initLocationProperties(): void
    {
        $this->locationProperties = (new LocationPropertiesFactory())->createFromArray($this->type, $this->properties);
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): LocationCountryEnum
    {
        return $this->country;
    }

    public function getType(): LocationTypeEnum
    {
        return $this->type;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getAvailable(): ?int
    {
        return $this->available;
    }
}
