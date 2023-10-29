<?php

namespace App\Service\Docker\Endpoint;

class ContainerInspect extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;
    protected $id;

    /**
     * Return low-level information about a container.
     *
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var bool $size Return the size of container as fields `SizeRw` and `SizeRootFs`
     *           }
     */
    public function __construct(string $id, array $queryParameters = [])
    {
        $this->id = $id;
        $this->queryParameters = $queryParameters;
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getUri(): string
    {
        return str_replace(['{id}'], [$this->id], '/containers/{id}/json');
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
        $optionsResolver->setDefined(['size']);
        $optionsResolver->setRequired([]);
        $optionsResolver->setDefaults(['size' => false]);
        $optionsResolver->addAllowedTypes('size', ['bool']);

        return $optionsResolver;
    }

    /**
     * @return \App\Service\Docker\Model\ContainersIdJsonGetResponse200|null
     *
     * @throws \App\Service\Docker\Exception\ContainerInspectNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerInspectInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return $serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ContainersIdJsonGetResponse200', 'json');
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\ContainerInspectNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\ContainerInspectInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
