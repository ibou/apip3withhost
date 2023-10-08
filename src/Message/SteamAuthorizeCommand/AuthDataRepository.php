<?php

declare(strict_types=1);

namespace App\Message\SteamAuthorizeCommand;

use Predis\Client as RedisClient;
use Symfony\Component\Uid\Uuid;

readonly class AuthDataRepository
{
    public function __construct(private RedisClient $client)
    {
    }

    public function read(Uuid $id): ?AuthData
    {
        $authData = $this->client->get($id->toBase32());
        if ($authData) {
            return unserialize($authData);
        }
        return null;
    }

    public function write(Uuid $id, AuthData $data): void
    {
        $uuid = $id->toBase32();
        $this->client->set($uuid, serialize($data));
        $this->client->expire($uuid, 30);
    }
}