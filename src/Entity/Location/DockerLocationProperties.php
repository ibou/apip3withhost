<?php

declare(strict_types=1);

namespace App\Entity\Location;

use App\Entity\Location\Exception\InvalidConnectionDataArgumentException;
use App\Entity\Location\Exception\InvalidHostArgumentException;
use App\Entity\Location\Exception\InvalidPortArgumentException;

readonly class DockerLocationProperties implements LocationPropertiesInterface
{
    public function __construct(
        public ?string $host,
        public ?int $port,
        public ?string $socket,
        public ?string $caFilePath,
        public ?string $localCertPath,
        public ?string $localPrivateKeyPath,
    ) {
        if (!$this->host && $this->port) {
            throw new InvalidHostArgumentException();
        }

        if (!$this->port && $this->host) {
            throw new InvalidPortArgumentException();
        }

        if (!$this->host && !$this->port && !$this->socket) {
            throw new InvalidConnectionDataArgumentException();
        }

        if ($this->host && $this->port && $this->socket) {
            throw new InvalidConnectionDataArgumentException();
        }
    }
}