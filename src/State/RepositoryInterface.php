<?php

declare(strict_types=1);

namespace App\State;

use App\Message\SteamAuthorizeCommand\AuthData;
use Symfony\Component\Uid\Uuid;

interface RepositoryInterface
{
    public function read(Uuid $id): ?object;

    public function write(Uuid $id, AuthData $data): bool;

    public function remove(Uuid $id): bool;
}