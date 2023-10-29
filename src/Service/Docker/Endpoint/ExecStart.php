<?php

namespace App\Service\Docker\Endpoint;

class ExecStart extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;
    protected $id;

    /**
     * Starts a previously set up exec instance. If detach is true, this endpoint
     * returns immediately after starting the command. Otherwise, it sets up an
     * interactive session with the command.
     *
     * @param string $id Exec instance ID
     */
    public function __construct(string $id, \App\Service\Docker\Model\ExecIdStartPostBody $execStartConfig)
    {
        $this->id = $id;
        $this->body = $execStartConfig;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return str_replace(['{id}'], [$this->id], '/exec/{id}/start');
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
     * @throws \App\Service\Docker\Exception\ExecStartNotFoundException
     * @throws \App\Service\Docker\Exception\ExecStartConflictException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return null;
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\ExecStartNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (409 === $status) {
            throw new \App\Service\Docker\Exception\ExecStartConflictException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
