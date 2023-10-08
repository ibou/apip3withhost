<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Message\SteamAuthorizeCommand;
use App\Message\SteamAuthorizeCommand\AuthDataRepository;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class AuthViaSteamStateProcessor implements ProcessorInterface
{
    public function __construct(
        private AuthDataRepository  $repository,
        private MessageBusInterface $bus
    ){
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        if ($data instanceof SteamAuthorizeCommand\AuthData) {
            $this->handle($data);
        }
    }

    private function handle(SteamAuthorizeCommand\AuthData $data): void
    {
        $this->repository->write($data->uuid, $data);
        $this->bus->dispatch(new SteamAuthorizeCommand($data->uuid));
    }
}
