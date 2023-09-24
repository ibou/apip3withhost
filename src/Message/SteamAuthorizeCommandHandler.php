<?php

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class SteamAuthorizeCommandHandler
{
    public function __invoke(SteamAuthorizeCommand $command)
    {
        // ... do some work - like sending an SMS message!
    }
}