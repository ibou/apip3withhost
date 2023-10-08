<?php

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\Uid\Uuid;

readonly class SteamAuthorizeCommand
{
    public function __construct(
        public Uuid $uuid
    ) {
    }
}