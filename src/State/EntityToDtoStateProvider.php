<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Service\SimpleMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class EntityToDtoStateProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: ItemProvider::class)] private ProviderInterface $itemProvider,
        #[Autowire(service: CollectionProvider::class)] private ProviderInterface $collectionProvider,
        protected SimpleMapper $mapper,
    ){
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $resourceClass = $operation->getClass();
        if ($operation instanceof CollectionOperationInterface) {
            $entities = $this->collectionProvider->provide($operation, $uriVariables, $context);
            assert($entities instanceof Paginator);

            $dtos = [];
            foreach ($entities as $entity) {
                $dtos[] = $this->mapper->mapToResourceApi($entity, $resourceClass);
            }

            return new TraversablePaginator(
                new \ArrayIterator($dtos),
                $entities->getCurrentPage(),
                $entities->getItemsPerPage(),
                $entities->getTotalItems()
            );
        }

        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity) {
            return null;
        }

        return $this->mapper->mapToResourceApi($entity, $resourceClass);
    }
}
