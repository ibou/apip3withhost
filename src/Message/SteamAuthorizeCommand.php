<?php

declare(strict_types=1);

namespace App\Message;

readonly class SteamAuthorizeCommand
{
    public function __construct(
        public string $id
    ) {
    }
}