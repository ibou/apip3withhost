<?php

namespace App\Service\Docker\Endpoint;

class ContainerExec extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;
    protected $id;

    /**
     * Run a command inside a running container.
     *
     * @param string                                             $id         ID or name of container
     * @param \App\Service\Docker\Model\ContainersIdExecPostBody $execConfig Exec configuration
     */
    public function __construct(string $id, \App\Service\Docker\Model\ContainersIdExecPostBody $execConfig)
    {
        $this->id = $id;
        $this->body = $execConfig;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return str_replace(['{id}'], [$this->id], '/containers/{id}/exec');
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
     * @return \App\Service\Docker\Model\IdResponse|null
     *
     * @throws \App\Service\Docker\Exception\ContainerExecNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerExecConflictException
     * @throws \App\Service\Docker\Exception\ContainerExecInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (201 === $status) {
            return $serializer->deserialize($body, 'App\\Service\\Docker\\Model\\IdResponse', 'json');
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\ContainerExecNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (409 === $status) {
            throw new \App\Service\Docker\Exception\ContainerExecConflictException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\ContainerExecInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
