<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\Operation;
use App\Service\SimpleMapper;
use Predis\Client as RedisClient;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class AbstractStateOperation
{
    public function __construct(
        protected SimpleMapper $mapper,
        #[Autowire('@authorize.dataStorage.predis')] protected RedisClient $client,
    ) {
    }

    protected function getEntityClass(Operation $operation): string
    {
        $stateOptions = $operation->getStateOptions();
        assert($stateOptions instanceof Options);
        $entityClass = $stateOptions->getEntityClass();
        if (!$entityClass) {
            throw new \Exception('Missing entityClass definition.');
        }
        return $entityClass;
    }

    protected function getRepositoryObject(string $entityClass): RepositoryInterface
    {
        $repositoryClass = $entityClass . 'Repository';
        return new $repositoryClass($this->client);
    }
}