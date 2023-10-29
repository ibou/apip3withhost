<?php

namespace App\Service\Docker\Endpoint;

class GetPluginPrivileges extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;

    /**
     * @param array $queryParameters {
     *
     * @var string $remote The name of the plugin. The `:latest` tag is optional, and is the
     *             default if omitted.
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
        return '/plugins/privileges';
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
        $optionsResolver->setDefined(['remote']);
        $optionsResolver->setRequired(['remote']);
        $optionsResolver->setDefaults([]);
        $optionsResolver->addAllowedTypes('remote', ['string']);

        return $optionsResolver;
    }

    /**
     * @return \App\Service\Docker\Model\PluginPrivilege[]|null
     *
     * @throws \App\Service\Docker\Exception\GetPluginPrivilegesInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return $serializer->deserialize($body, 'App\\Service\\Docker\\Model\\PluginPrivilege[]', 'json');
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\GetPluginPrivilegesInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
