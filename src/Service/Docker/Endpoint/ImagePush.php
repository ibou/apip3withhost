<?php

namespace App\Service\Docker\Endpoint;

class ImagePush extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;
    protected $name;

    /**
     * Push an image to a registry.
     *
     * If you wish to push an image on to a private registry, that image must
     * already have a tag which references the registry. For example,
     * `registry.example.com/myimage:latest`.
     *
     * The push is cancelled if the HTTP connection is closed.
     *
     * @param string $name            image name or ID
     * @param array  $queryParameters {
     *
     * @var string $tag The tag to associate with the image on the registry.
     *             }
     *
     * @param array $headerParameters {
     *
     * @var string $X-Registry-Auth A base64url-encoded auth configuration.
     *
     * Refer to the [authentication section](#section/Authentication) for
     * details.
     *
     * }
     */
    public function __construct(string $name, array $queryParameters = [], array $headerParameters = [])
    {
        $this->name = $name;
        $this->queryParameters = $queryParameters;
        $this->headerParameters = $headerParameters;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return str_replace(['{name}'], [$this->name], '/images/{name}/push');
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
        $optionsResolver->setDefined(['tag']);
        $optionsResolver->setRequired([]);
        $optionsResolver->setDefaults([]);
        $optionsResolver->addAllowedTypes('tag', ['string']);

        return $optionsResolver;
    }

    protected function getHeadersOptionsResolver(): \Symfony\Component\OptionsResolver\OptionsResolver
    {
        $optionsResolver = parent::getHeadersOptionsResolver();
        $optionsResolver->setDefined(['X-Registry-Auth']);
        $optionsResolver->setRequired(['X-Registry-Auth']);
        $optionsResolver->setDefaults([]);
        $optionsResolver->addAllowedTypes('X-Registry-Auth', ['string']);

        return $optionsResolver;
    }

    /**
     * @return null
     *
     * @throws \App\Service\Docker\Exception\ImagePushNotFoundException
     * @throws \App\Service\Docker\Exception\ImagePushInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return null;
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\ImagePushNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\ImagePushInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
