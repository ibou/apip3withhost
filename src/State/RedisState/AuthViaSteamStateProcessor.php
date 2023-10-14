<?php

declare(strict_types=1);

namespace App\State\RedisState;

use ApiPlatform\Metadata\Operation;
use App\ApiResource\PostAuthViaSteamResource;
use App\Message\SteamAuthorizeCommand;
use App\Service\SimpleMapper;
use Predis\Client as RedisClient;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\MessageBusInterface;

class AuthViaSteamStateProcessor extends EntityClassDtoStateProcessor
{
    public function __construct(
        protected SimpleMapper $mapper,
        protected MessageBusInterface $bus,
        #[Autowire('@authorize.dataStorage.predis')] protected RedisClient $client,
    )
    {
        parent::__construct($mapper, $client);
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        assert($data instanceof PostAuthViaSteamResource);
        $result = parent::process($data, $operation, $uriVariables, $context);

        $this->bus->dispatch(new SteamAuthorizeCommand($data->uuid));

        return $result;
    }
}