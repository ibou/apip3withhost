<?php

namespace App\Service\Docker\Endpoint;

class SwarmLeave extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;

    /**
     * @param array $queryParameters {
     *
     * @var bool $force Force leave swarm, even if this is the last manager or that it will
     *           break the cluster.
     *
     * }
     */
    public function __construct(array $queryParameters = [])
    {
        $this->queryParameters = $queryParameters;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return '/swarm/leave';
    }

    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null): array
    {
        return [[], null];
    }

    public function getExtraHeaders(): array
    {
        return ['Accept' => ['application/json']];
    }

    protected function getQueryOptionsResolver(): \Symfony\Component\OptionsResolver\OptionsResolver
    {
        $optionsResolver = parent::getQueryOptionsResolver();
        $optionsResolver->setDefined(['force']);
        $optionsResolver->setRequired([]);
        $optionsResolver->setDefaults(['force' => false]);
        $optionsResolver->addAllowedTypes('force', ['bool']);

        return $optionsResolver;
    }

    /**
     * @return null
     *
     * @throws \App\Service\Docker\Exception\SwarmLeaveInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SwarmLeaveServiceUnavailableException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return null;
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\SwarmLeaveInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (503 === $status) {
            throw new \App\Service\Docker\Exception\SwarmLeaveServiceUnavailableException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
