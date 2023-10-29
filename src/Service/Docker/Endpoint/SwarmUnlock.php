<?php

namespace App\Service\Docker\Endpoint;

class SwarmUnlock extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;

    public function __construct(\App\Service\Docker\Model\SwarmUnlockPostBody $body)
    {
        $this->body = $body;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return '/swarm/unlock';
    }

    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null): array
    {
        return $this->getSerializedBody($serializer);
    }

    public function getExtraHeaders(): array
    {
        return ['Accept' => ['application/json']];
    }

    /**
     * @return null
     *
     * @throws \App\Service\Docker\Exception\SwarmUnlockInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SwarmUnlockServiceUnavailableException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return null;
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\SwarmUnlockInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (503 === $status) {
            throw new \App\Service\Docker\Exception\SwarmUnlockServiceUnavailableException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
