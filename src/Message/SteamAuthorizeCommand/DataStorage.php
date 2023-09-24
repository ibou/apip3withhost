<?php

declare(strict_types=1);

namespace App\Message\SteamAuthorizeCommand;

use Predis\Client as RedisClient;

readonly class DataStorage
{
    public function __construct(private RedisClient $client)
    {
    }

    public function read(string $id): Data
    {
        return unserialize($this->client->get($id));
    }

    public function write(string $id, Data $data): void
    {
        $this->client->set($id, serialize($data));
        $this->client->expire($id, 30);
    }
}