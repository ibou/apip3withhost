<?php

declare(strict_types=1);

namespace App\Message\SteamAuthorizeCommand;

use App\State\RedisState\RepositoryInterface;
use Predis\Client as RedisClient;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Uid\Uuid;

readonly class AuthDataRepository implements RepositoryInterface
{
    public function __construct(
        #[Autowire('@authorize.dataStorage.predis')] private RedisClient $client,
    ) {
    }

    public function read(Uuid $id): ?AuthData
    {
        $authData = $this->client->get($id->toBase32());
        if ($authData) {
            return unserialize($authData);
        }
        return null;
    }

    public function write(Uuid $id, AuthData $data, bool $force = false): bool
    {
        $uuid = $id->toBase32();
        if (!$force && $this->client->exists($uuid)) {
            return false;
        }

        $this->client->set($uuid, serialize($data));
        $this->client->expire($uuid, 30);

        return true;
    }

    public function remove(Uuid $id): bool
    {
        $uuid = $id->toBase32();
        if (!$this->client->exists($uuid)) {
            return false;
        }

        $this->client->del($uuid);
        return true;
    }
}