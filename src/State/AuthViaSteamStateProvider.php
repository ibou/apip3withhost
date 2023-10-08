<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Message\SteamAuthorizeCommand\AuthDataRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Uid\Uuid;

class AuthViaSteamStateProvider implements ProviderInterface
{
    public function __construct(
        private AuthDataRepository $repository,
    ){
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $uuid = $uriVariables['uuid'] ?? null;

        if (!($uuid instanceof Uuid)) {
            throw new BadRequestHttpException('Invalid uuid.');
        }

        return $this->repository->read($uuid);
    }
}
