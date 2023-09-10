<?php

declare(strict_types=1);

namespace App\Entity\Service;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;

#[
    ApiResource(
        shortName: 'ServiceStatus',
        paginationEnabled: false,
    ),
    GetCollection(
        uriTemplate: '/service-status',
        openapi: new Operation(
            responses: [
                200 => new \ApiPlatform\OpenApi\Model\Response(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'type' => 'array',
                                'items' => [
                                    'type' => 'string'
                                ]
                            ]
                        ],
                    ])
                )
            ]
        ),
        provider: ServiceStatusEnum::class.'::getCases'
    )
]
enum ServiceStatusEnum: string
{
    case STATUS_CREATING = 'creating';
    case STATUS_STARTING = 'starting';
    case STATUS_RUNNING = 'running';
    case STATUS_STOPPING = 'stopping';

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
}
