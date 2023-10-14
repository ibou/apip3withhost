<?php

declare(strict_types=1);

namespace App\Message\SteamAuthorizeCommand;

use Symfony\Component\Uid\Uuid;

readonly class AuthData
{
    public function __construct(
        public Uuid $uuid,
        public string $ns,
        public string $mode,
        public string $op_endpoint,
        public string $claimed_id,
        public string $identity,
        public string $return_to,
        public string $response_nonce,
        public string $assoc_handle,
        public string $signed,
        public string $sig,
        public ClientChecksum $checksum,
        public bool $isAuthenticated = false,
        public bool $isProcessing = true,
        public ?string $token = null,
    ) {
    }

    public function parseSteamId(): string
    {
        preg_match('#^https://steamcommunity.com/openid/id/(\d+)#', $this->claimed_id, $matches);
        return $matches[1];
    }

    public function makeFinishedProcessing(?string $token = null): self
    {
        $properties = get_object_vars($this);
        $properties['isProcessing'] = false;
        if ($token) {
            $properties['isAuthenticated'] = true;
            $properties['token'] = $token;
        }

        return new self(...$properties);
    }

    public function __serialize(): array
    {
        return get_object_vars($this);
    }

    public function __unserialize(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}