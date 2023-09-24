<?php

declare(strict_types=1);

namespace App\Message\SteamAuthorizeCommand;

readonly class Data
{
    public function __construct(
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
        public bool $isAuthenticated = false
    ) {
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