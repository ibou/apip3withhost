<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Message\SteamAuthorizeCommand\AuthData;
use App\State\AuthViaSteamStateProcessor;
use App\State\AuthViaSteamStateProvider;

#[
    ApiResource(
        formats: ['json'],
        normalizationContext: ['user:read'],
        denormalizationContext: ['user:write'],
    ),
    Get(
        uriTemplate: '/auth-via-steam/{uuid}',
        name: 'get-auth-via-steam',
        provider: AuthViaSteamStateProvider::class
    ),
    Post(
        uriTemplate: '/auth-via-steam',
        status: 202,
        output: false,
        name: 'post-auth-via-steam',
        processor: AuthViaSteamStateProcessor::class
    )
]

readonly class AuthViaSteamResource extends AuthData
{

}