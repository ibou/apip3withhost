<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Response;
use App\Message\SteamAuthorizeCommand\AuthData;
use App\State\RedisState\AuthViaSteamStateProcessor;
use Symfony\Component\Uid\Uuid;

#[
    ApiResource(
        shortName: 'AuthViaSteam',
        operations: [
            new Post(
                uriTemplate: '/auth-via-steam',
                status: 202,
                openapi: new Operation(
                    responses: [
                        '202' => new Response(
                            'Accepted'
                        )
                    ]
                ),
                output: false,
                read: false,
                name: 'post-auth-via-steam',
            )
        ],
        formats: ['json'],
        processor: AuthViaSteamStateProcessor::class,
        stateOptions: new Options(entityClass: AuthData::class)
    ),
]
class PostAuthViaSteamResource
{
    #[ApiProperty(identifier: true)]
    public Uuid $uuid;
    public string $ns;
    public string $mode;
    public string $op_endpoint;
    public string $claimed_id;
    public string $identity;
    public string $return_to;
    public string $response_nonce;
    public string $assoc_handle;
    public string $signed;
    public string $sig;
}