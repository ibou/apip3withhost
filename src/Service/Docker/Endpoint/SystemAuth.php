<?php

namespace App\Service\Docker\Endpoint;

class SystemAuth extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;

    /**
     * Validate credentials for a registry and, if available, get an identity
     * token for accessing the registry without password.
     *
     * @param \App\Service\Docker\Model\AuthConfig $authConfig Authentication to check
     */
    public function __construct(\App\Service\Docker\Model\AuthConfig $authConfig)
    {
        $this->body = $authConfig;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return '/auth';
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
     * @return \App\Service\Docker\Model\AuthPostResponse200|null
     *
     * @throws \App\Service\Docker\Exception\SystemAuthUnauthorizedException
     * @throws \App\Service\Docker\Exception\SystemAuthInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return $serializer->deserialize($body, 'App\\Service\\Docker\\Model\\AuthPostResponse200', 'json');
        }
        if (204 === $status) {
            return null;
        }
        if (401 === $status) {
            throw new \App\Service\Docker\Exception\SystemAuthUnauthorizedException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\SystemAuthInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
