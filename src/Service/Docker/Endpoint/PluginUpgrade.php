<?php

namespace App\Service\Docker\Endpoint;

class PluginUpgrade extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;
    protected $name;

    /**
     * @param string                                      $name            The name of the plugin. The `:latest` tag is optional, and is the
     *                                                                     default if omitted.
     * @param \App\Service\Docker\Model\PluginPrivilege[] $body
     * @param array                                       $queryParameters {
     *
     * @var string $remote Remote reference to upgrade to.
     *
     * The `:latest` tag is optional, and is used as the default if omitted.
     *
     * }
     *
     * @param array $headerParameters {
     *
     * @var string $X-Registry-Auth A base64url-encoded auth configuration to use when pulling a plugin
     *             from a registry.
     *
     * Refer to the [authentication section](#section/Authentication) for
     * details.
     *
     * }
     */
    public function __construct(string $name, array $body, array $queryParameters = [], array $headerParameters = [])
    {
        $this->name = $name;
        $this->body = $body;
        $this->queryParameters = $queryParameters;
        $this->headerParameters = $headerParameters;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return str_replace(['{name}'], [$this->name], '/plugins/{name}/upgrade');
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
        $optionsResolver->setDefined(['remote']);
        $optionsResolver->setRequired(['remote']);
        $optionsResolver->setDefaults([]);
        $optionsResolver->addAllowedTypes('remote', ['string']);

        return $optionsResolver;
    }

    protected function getHeadersOptionsResolver(): \Symfony\Component\OptionsResolver\OptionsResolver
    {
        $optionsResolver = parent::getHeadersOptionsResolver();
        $optionsResolver->setDefined(['X-Registry-Auth']);
        $optionsResolver->setRequired([]);
        $optionsResolver->setDefaults([]);
        $optionsResolver->addAllowedTypes('X-Registry-Auth', ['string']);

        return $optionsResolver;
    }

    /**
     * @return null
     *
     * @throws \App\Service\Docker\Exception\PluginUpgradeNotFoundException
     * @throws \App\Service\Docker\Exception\PluginUpgradeInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (204 === $status) {
            return null;
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\PluginUpgradeNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\PluginUpgradeInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
