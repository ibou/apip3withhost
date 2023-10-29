<?php

namespace App\Service\Docker\Endpoint;

class ImageList extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;

    /**
     * Returns a list of images on the server. Note that it uses a different, smaller representation of an image than inspecting a single image.
     *
     * @param array $queryParameters {
     *
     * @var bool   $all Show all images. Only images from a final layer (no children) are shown by default.
     * @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to
     *             process on the images list.
     *
     * Available filters:
     *
     * - `before`=(`<image-name>[:<tag>]`,  `<image id>` or `<image@digest>`)
     * - `dangling=true`
     * - `label=key` or `label="key=value"` of an image label
     * - `reference`=(`<image-name>[:<tag>]`)
     * - `since`=(`<image-name>[:<tag>]`,  `<image id>` or `<image@digest>`)
     * @var bool $shared-size Compute and show shared size as a `SharedSize` field on each image
     * @var bool $digests Show digest information as a `RepoDigests` field on each image.
     *           }
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
        return '/images/json';
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
        $optionsResolver->setDefined(['all', 'filters', 'shared-size', 'digests']);
        $optionsResolver->setRequired([]);
        $optionsResolver->setDefaults(['all' => false, 'shared-size' => false, 'digests' => false]);
        $optionsResolver->addAllowedTypes('all', ['bool']);
        $optionsResolver->addAllowedTypes('filters', ['string']);
        $optionsResolver->addAllowedTypes('shared-size', ['bool']);
        $optionsResolver->addAllowedTypes('digests', ['bool']);

        return $optionsResolver;
    }

    /**
     * @return \App\Service\Docker\Model\ImageSummary[]|null
     *
     * @throws \App\Service\Docker\Exception\ImageListInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return $serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ImageSummary[]', 'json');
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\ImageListInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
