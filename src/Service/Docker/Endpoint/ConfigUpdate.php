<?php

namespace App\Service\Docker\Endpoint;

class ConfigUpdate extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;
    protected $id;

    /**
     * @param string                               $id              The ID or name of the config
     * @param \App\Service\Docker\Model\ConfigSpec $body            The spec of the config to update. Currently, only the Labels field
     *                                                              can be updated. All other fields must remain unchanged from the
     *                                                              [ConfigInspect endpoint](#operation/ConfigInspect) response values.
     * @param array                                $queryParameters {
     *
     * @var int $version The version number of the config object being updated. This is
     *          required to avoid conflicting writes.
     *
     * }
     */
    public function __construct(string $id, \App\Service\Docker\Model\ConfigSpec $body, array $queryParameters = [])
    {
        $this->id = $id;
        $this->body = $body;
        $this->queryParameters = $queryParameters;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return str_replace(['{id}'], [$this->id], '/configs/{id}/update');
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
        $optionsResolver->setDefined(['version']);
        $optionsResolver->setRequired(['version']);
        $optionsResolver->setDefaults([]);
        $optionsResolver->addAllowedTypes('version', ['int']);

        return $optionsResolver;
    }

    /**
     * @return null
     *
     * @throws \App\Service\Docker\Exception\ConfigUpdateBadRequestException
     * @throws \App\Service\Docker\Exception\ConfigUpdateNotFoundException
     * @throws \App\Service\Docker\Exception\ConfigUpdateInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ConfigUpdateServiceUnavailableException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return null;
        }
        if (400 === $status) {
            throw new \App\Service\Docker\Exception\ConfigUpdateBadRequestException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\ConfigUpdateNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\ConfigUpdateInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (503 === $status) {
            throw new \App\Service\Docker\Exception\ConfigUpdateServiceUnavailableException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
