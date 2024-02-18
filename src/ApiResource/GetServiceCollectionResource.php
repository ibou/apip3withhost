<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Action\PlaceholderAction;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Service;
use App\Entity\Service\ServicePropertiesInterface;
use App\Entity\Service\ServiceStatusEnum;
use App\Entity\Service\ServiceTypeEnum;
use App\State\EntityToDtoStateProvider;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Uid\Uuid;

#[
    ApiResource(
        shortName: 'Service',
        operations: [
            new GetCollection(
                uriTemplate: '/service',
                controller: PlaceholderAction::class,
                name: 'get-service-collection',
            ),
        ],
        formats: ['json'],
        provider: EntityToDtoStateProvider::class,
        stateOptions: new Options(entityClass: Service::class),
    ),
]
class GetServiceCollectionResource
{
    #[ApiProperty(identifier: true)]
    public ?Uuid $uuid;
    public string $name;
    public ServiceTypeEnum $type;
    public ServiceStatusEnum $status;

    public GetServiceResourceLocation $location;

    #[SerializedName('properties')]
    public ServicePropertiesInterface $serviceProperties;
}