<?php

namespace App\Service\Docker\Endpoint;

class TaskList extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;

    /**
     * @param array $queryParameters {
     *
     * @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to
     *             process on the tasks list.
     *
     * Available filters:
     *
     * - `desired-state=(running | shutdown | accepted)`
     * - `id=<task id>`
     * - `label=key` or `label="key=value"`
     * - `name=<task name>`
     * - `node=<node id or name>`
     * - `service=<service name>`
     *
     * }
     */
    public function __construct(array $queryParameters = [])
    {
        $this->queryParameters = $queryParameters;
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getUri(): string
    {
        return '/tasks';
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
        $optionsResolver->setDefined(['filters']);
        $optionsResolver->setRequired([]);
        $optionsResolver->setDefaults([]);
        $optionsResolver->addAllowedTypes('filters', ['string']);

        return $optionsResolver;
    }

    /**
     * @return \App\Service\Docker\Model\Task[]|null
     *
     * @throws \App\Service\Docker\Exception\TaskListInternalServerErrorException
     * @throws \App\Service\Docker\Exception\TaskListServiceUnavailableException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return $serializer->deserialize($body, 'App\\Service\\Docker\\Model\\Task[]', 'json');
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\TaskListInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (503 === $status) {
            throw new \App\Service\Docker\Exception\TaskListServiceUnavailableException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
