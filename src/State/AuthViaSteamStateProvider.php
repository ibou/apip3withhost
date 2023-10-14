<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use App\ApiResource\GetAuthViaSteamResource;
use App\Message\SteamAuthorizeCommand\ClientChecksum;
use App\Service\SimpleMapper;
use Predis\Client as RedisClient;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthViaSteamStateProvider extends EntityToDtoStateProvider
{
    public function __construct(
        protected SimpleMapper $mapper,
        protected ClientChecksum $checksum,
        #[Autowire('@authorize.dataStorage.predis')] protected RedisClient $client,
    ) {
        parent::__construct($this->mapper, $this->client);
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $resourceApi = parent::provide($operation, $uriVariables, $context);
        if (!$resourceApi) {
            return null;
        }

        assert($resourceApi instanceof GetAuthViaSteamResource);

        if (!$resourceApi->checksum->isSame($this->checksum)) {
            throw new AccessDeniedHttpException();
        }

        if ($resourceApi->isAuthenticatedSuccessfully()) {
            $repository = $this->getRepositoryObject($this->getEntityClass($operation));
            $repository->remove($this->getUuid($uriVariables));
        }

        return $resourceApi;
    }
}
