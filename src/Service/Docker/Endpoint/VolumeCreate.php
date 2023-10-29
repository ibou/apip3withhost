<?php

namespace App\Service\Docker\Endpoint;

class VolumeCreate extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;

    /**
     * @param \App\Service\Docker\Model\VolumeCreateOptions $volumeConfig Volume configuration
     */
    public function __construct(\App\Service\Docker\Model\VolumeCreateOptions $volumeConfig)
    {
        $this->body = $volumeConfig;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return '/volumes/create';
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
     * @return \App\Service\Docker\Model\Volume|null
     *
     * @throws \App\Service\Docker\Exception\VolumeCreateInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (201 === $status) {
            return $serializer->deserialize($body, 'App\\Service\\Docker\\Model\\Volume', 'json');
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\VolumeCreateInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
