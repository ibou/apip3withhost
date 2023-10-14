<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Action\PlaceholderAction;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Response;
use App\Message\SteamAuthorizeCommand\AuthData;
use App\Message\SteamAuthorizeCommand\ClientChecksum;
use App\State\AuthViaSteamStateProvider;
use Symfony\Component\Uid\Uuid;

#[
    ApiResource(
        shortName: 'VerifyAuthViaSteam',
        operations: [
            new Get(
                uriTemplate: '/auth-via-steam/{uuid}',
                controller: PlaceholderAction::class,
                openapi: new Operation(
                    responses: [
                        '403' => new Response(
                            'Forbidden'
                        )
                    ]
                ),
                name: 'get-auth-via-steam',
            ),
        ],
        formats: ['json'],
        provider: AuthViaSteamStateProvider::class,
        stateOptions: new Options(entityClass: AuthData::class),
    ),
]
class GetAuthViaSteamResource
{
    #[ApiProperty(readable: false, identifier: true)]
    public Uuid $uuid;
    public bool $isAuthenticated;
    public bool $isProcessing;
    public ?string $token;

    #[ApiProperty(readable: false)]
    public ?ClientChecksum $checksum;

    #[ApiProperty(readable: false)]
    public function isAuthenticatedSuccessfully(): bool
    {
        return $this->isAuthenticated && !$this->isProcessing;
    }
}