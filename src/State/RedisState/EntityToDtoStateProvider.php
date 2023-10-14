<?php

declare(strict_types=1);

namespace App\State\RedisState;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\Uid\Uuid;

class EntityToDtoStateProvider extends AbstractStateOperation implements ProviderInterface
{
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            throw new \LogicException('Collection operation is no supported.');
        }

        $resourceClass = $operation->getClass();
        $uuid = $this->getUuid($uriVariables);

        $repository = $this->getRepositoryObject($this->getEntityClass($operation));
        $entity = $repository->read($uuid);
        if (!$entity) {
            return null;
        }

        return $this->mapper->mapToResourceApi($entity, $resourceClass);
    }

    protected function getUuid($uriVariables): Uuid
    {
        $uuid = $uriVariables['uuid'] ?? null;
        assert($uuid instanceof Uuid);
        return $uuid;
    }
}
