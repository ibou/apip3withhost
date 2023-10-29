<?php

namespace App\Service\Docker\Endpoint;

class ContainerList extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;

    /**
     * Returns a list of containers. For details on the format, see the
     * [inspect endpoint](#operation/ContainerInspect).
     *
     * Note that it uses a different, smaller representation of a container
     * than inspecting a single container. For example, the list of linked
     * containers is not propagated .
     *
     * @param array $queryParameters {
     *
     * @var bool   $all Return all containers. By default, only running containers are shown.
     * @var int    $limit return this number of most recently created containers, including
     *             non-running ones
     * @var bool   $size return the size of container as fields `SizeRw` and `SizeRootFs`
     * @var string $filters Filters to process on the container list, encoded as JSON (a
     *             `map[string][]string`). For example, `{"status": ["paused"]}` will
     *             only return paused containers.
     *
     * Available filters:
     *
     * - `ancestor`=(`<image-name>[:<tag>]`, `<image id>`, or `<image@digest>`)
     * - `before`=(`<container id>` or `<container name>`)
     * - `expose`=(`<port>[/<proto>]`|`<startport-endport>/[<proto>]`)
     * - `exited=<int>` containers with exit code of `<int>`
     * - `health`=(`starting`|`healthy`|`unhealthy`|`none`)
     * - `id=<ID>` a container's ID
     * - `isolation=`(`default`|`process`|`hyperv`) (Windows daemon only)
     * - `is-task=`(`true`|`false`)
     * - `label=key` or `label="key=value"` of a container label
     * - `name=<name>` a container's name
     * - `network`=(`<network id>` or `<network name>`)
     * - `publish`=(`<port>[/<proto>]`|`<startport-endport>/[<proto>]`)
     * - `since`=(`<container id>` or `<container name>`)
     * - `status=`(`created`|`restarting`|`running`|`removing`|`paused`|`exited`|`dead`)
     * - `volume`=(`<volume name>` or `<mount point destination>`)
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
        return '/containers/json';
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
        $optionsResolver->setDefined(['all', 'limit', 'size', 'filters']);
        $optionsResolver->setRequired([]);
        $optionsResolver->setDefaults(['all' => false, 'size' => false]);
        $optionsResolver->addAllowedTypes('all', ['bool']);
        $optionsResolver->addAllowedTypes('limit', ['int']);
        $optionsResolver->addAllowedTypes('size', ['bool']);
        $optionsResolver->addAllowedTypes('filters', ['string']);

        return $optionsResolver;
    }

    /**
     * @return \App\Service\Docker\Model\ContainerSummary[]|null
     *
     * @throws \App\Service\Docker\Exception\ContainerListBadRequestException
     * @throws \App\Service\Docker\Exception\ContainerListInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return $serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ContainerSummary[]', 'json');
        }
        if (400 === $status) {
            throw new \App\Service\Docker\Exception\ContainerListBadRequestException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\ContainerListInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
