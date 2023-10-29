<?php

namespace App\Service\Docker\Endpoint;

class NetworkDisconnect extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;
    protected $id;

    /**
     * @param string $id Network ID or name
     */
    public function __construct(string $id, \App\Service\Docker\Model\NetworksIdDisconnectPostBody $container)
    {
        $this->id = $id;
        $this->body = $container;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return str_replace(['{id}'], [$this->id], '/networks/{id}/disconnect');
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
     * @throws \App\Service\Docker\Exception\NetworkDisconnectForbiddenException
     * @throws \App\Service\Docker\Exception\NetworkDisconnectNotFoundException
     * @throws \App\Service\Docker\Exception\NetworkDisconnectInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return null;
        }
        if (403 === $status) {
            throw new \App\Service\Docker\Exception\NetworkDisconnectForbiddenException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\NetworkDisconnectNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\NetworkDisconnectInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
