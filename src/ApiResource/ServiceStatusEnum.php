<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Response;

#[
    ApiResource(
        shortName: 'ServiceStatus',
        paginationEnabled: false,
    ),
    GetCollection(
        uriTemplate: '/service-status',
        openapi: new Operation(
            responses: [
                200 => new Response(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'type' => 'array',
                                'items' => [
                                    'type' => 'string',
                                    'example' => 'creating',
                                ],
                            ],
                        ],
                    ])
                )
            ],
            description: 'Lists available service statuses.',
        ),
        shortName: 'Service',
        provider: ServiceStatusEnum::class.'::getCases'
    )
]
/**
 * @method static self CREATING()
 * @method static self STARTING()
 * @method static self RUNNING()
 * @method static self STOPPING()
 * @method static self STOPPED()
 */
enum ServiceStatusEnum: string
{
    use ServiceStatusEnumTrait;

    case STATUS_CREATING = 'creating';
    case STATUS_STARTING = 'starting';
    case STATUS_RUNNING = 'running';
    case STATUS_STOPPING = 'stopping';
    case STATUS_STOPPED = 'stopped';
}
