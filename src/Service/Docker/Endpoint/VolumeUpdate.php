<?php

namespace App\Service\Docker\Endpoint;

class VolumeUpdate extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;
    protected $name;

    /**
     * @param string                                       $name            The name or ID of the volume
     * @param \App\Service\Docker\Model\VolumesNamePutBody $body            The spec of the volume to update. Currently, only Availability may
     *                                                                      change. All other fields must remain unchanged.
     * @param array                                        $queryParameters {
     *
     * @var int $version The version number of the volume being updated. This is required to
     *          avoid conflicting writes. Found in the volume's `ClusterVolume`
     *          field.
     *
     * }
     */
    public function __construct(string $name, \App\Service\Docker\Model\VolumesNamePutBody $body, array $queryParameters = [])
    {
        $this->name = $name;
        $this->body = $body;
        $this->queryParameters = $queryParameters;
    }

    public function getMethod(): string
    {
        return 'PUT';
    }

    public function getUri(): string
    {
        return str_replace(['{name}'], [$this->name], '/volumes/{name}');
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
     * @throws \App\Service\Docker\Exception\VolumeUpdateBadRequestException
     * @throws \App\Service\Docker\Exception\VolumeUpdateNotFoundException
     * @throws \App\Service\Docker\Exception\VolumeUpdateInternalServerErrorException
     * @throws \App\Service\Docker\Exception\VolumeUpdateServiceUnavailableException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return null;
        }
        if (400 === $status) {
            throw new \App\Service\Docker\Exception\VolumeUpdateBadRequestException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\VolumeUpdateNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\VolumeUpdateInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (503 === $status) {
            throw new \App\Service\Docker\Exception\VolumeUpdateServiceUnavailableException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
