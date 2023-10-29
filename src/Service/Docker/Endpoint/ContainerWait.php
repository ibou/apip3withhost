<?php

namespace App\Service\Docker\Endpoint;

class ContainerWait extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;
    protected $id;

    /**
     * Block until a container stops, then returns the exit code.
     *
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var string $condition Wait until a container state reaches the given condition.
     *
     * Defaults to `not-running` if omitted or empty.
     *
     * }
     */
    public function __construct(string $id, array $queryParameters = [])
    {
        $this->id = $id;
        $this->queryParameters = $queryParameters;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return str_replace(['{id}'], [$this->id], '/containers/{id}/wait');
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
        $optionsResolver->setDefined(['condition']);
        $optionsResolver->setRequired([]);
        $optionsResolver->setDefaults(['condition' => 'not-running']);
        $optionsResolver->addAllowedTypes('condition', ['string']);

        return $optionsResolver;
    }

    /**
     * @return \App\Service\Docker\Model\ContainerWaitResponse|null
     *
     * @throws \App\Service\Docker\Exception\ContainerWaitBadRequestException
     * @throws \App\Service\Docker\Exception\ContainerWaitNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerWaitInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return $serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ContainerWaitResponse', 'json');
        }
        if (400 === $status) {
            throw new \App\Service\Docker\Exception\ContainerWaitBadRequestException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\ContainerWaitNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\ContainerWaitInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
