<?php

declare(strict_types=1);

namespace App\Message\SteamAuthorizeCommand;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ClientChecksum
{
    public function __construct(
        private ?string $checksum = null,
        #[Autowire('%env(REMOTE_ADDR)%')] private readonly ?string $ipAddress = null,
        #[Autowire('%env(HTTP_USER_AGENT)%')] private readonly ?string $userAgent = null,
    ) {
        if (!$this->checksum) {
            $this->checksum = $this->generateChecksum();
        }
    }

    public function isSame(ClientChecksum $checksum): bool
    {
        return $this->checksum === $checksum->checksum;
    }

    private function generateChecksum(): string
    {
        $ipAddress = $this->ipAddress ?? ($_SERVER['REMOTE_ADDR'] ?? '');
        $userAgent = $this->userAgent ?? ($_SERVER['HTTP_USER_AGENT'] ?? '');

        return sha1($ipAddress . ':' . $userAgent);
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