<?php

namespace App\Service\Docker\Endpoint;

class ContainerUpdate extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;
    protected $id;

    /**
     * Change various configuration options of a container without having to
     * recreate it.
     *
     * @param string $id ID or name of the container
     */
    public function __construct(string $id, \App\Service\Docker\Model\ContainersIdUpdatePostBody $update)
    {
        $this->id = $id;
        $this->body = $update;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return str_replace(['{id}'], [$this->id], '/containers/{id}/update');
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
     * @return \App\Service\Docker\Model\ContainersIdUpdatePostResponse200|null
     *
     * @throws \App\Service\Docker\Exception\ContainerUpdateNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerUpdateInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return $serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ContainersIdUpdatePostResponse200', 'json');
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\ContainerUpdateNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\ContainerUpdateInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
