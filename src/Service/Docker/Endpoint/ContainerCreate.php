<?php

namespace App\Service\Docker\Endpoint;

class ContainerCreate extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;

    /**
     * @param \App\Service\Docker\Model\ContainersCreatePostBody $body            Container to create
     * @param array                                              $queryParameters {
     *
     * @var string $name Assign the specified name to the container. Must match
     *             `/?[a-zA-Z0-9][a-zA-Z0-9_.-]+`.
     * @var string $platform Platform in the format `os[/arch[/variant]]` used for image lookup.
     *
     * When specified, the daemon checks if the requested image is present
     * in the local image cache with the given OS and Architecture, and
     * otherwise returns a `404` status.
     *
     * If the option is not set, the host's native OS and Architecture are
     * used to look up the image in the image cache. However, if no platform
     * is passed and the given image does exist in the local image cache,
     * but its OS or architecture does not match, the container is created
     * with the available image, and a warning is added to the `Warnings`
     * field in the response, for example;
     *
     * WARNING: The requested image's platform (linux/arm64/v8) does not
     * match the detected host platform (linux/amd64) and no
     * specific platform was requested
     *
     * }
     */
    public function __construct(\App\Service\Docker\Model\ContainersCreatePostBody $body, array $queryParameters = [])
    {
        $this->body = $body;
        $this->queryParameters = $queryParameters;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return '/containers/create';
    }

    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null): array
    {
        return $this->getSerializedBody($serializer);
    }

    public function getExtraHeaders(): array
    {
        return ['Accept' => ['application/json']];
    }

    protected function getQueryOptionsResolver(): \Symfony\Component\OptionsResolver\OptionsResolver
    {
        $optionsResolver = parent::getQueryOptionsResolver();
        $optionsResolver->setDefined(['name', 'platform']);
        $optionsResolver->setRequired([]);
        $optionsResolver->setDefaults(['platform' => '']);
        $optionsResolver->addAllowedTypes('name', ['string']);
        $optionsResolver->addAllowedTypes('platform', ['string']);

        return $optionsResolver;
    }

    /**
     * @return \App\Service\Docker\Model\ContainerCreateResponse|null
     *
     * @throws \App\Service\Docker\Exception\ContainerCreateBadRequestException
     * @throws \App\Service\Docker\Exception\ContainerCreateNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerCreateConflictException
     * @throws \App\Service\Docker\Exception\ContainerCreateInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (201 === $status) {
            return $serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ContainerCreateResponse', 'json');
        }
        if (400 === $status) {
            throw new \App\Service\Docker\Exception\ContainerCreateBadRequestException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\ContainerCreateNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (409 === $status) {
            throw new \App\Service\Docker\Exception\ContainerCreateConflictException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\ContainerCreateInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
