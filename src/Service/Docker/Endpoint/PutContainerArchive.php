<?php

namespace App\Service\Docker\Endpoint;

class PutContainerArchive extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;
    protected $id;

    /**
     * Upload a tar archive to be extracted to a path in the filesystem of container id.
     * `path` parameter is asserted to be a directory. If it exists as a file, 400 error
     * will be returned with message "not a directory".
     *
     * @param string                                            $id              ID or name of the container
     * @param string|resource|\Psr\Http\Message\StreamInterface $inputStream     the input stream must be a tar archive compressed with one of the
     *                                                                           following algorithms: `identity` (no compression), `gzip`, `bzip2`,
     *                                                                           or `xz`
     * @param array                                             $queryParameters {
     *
     * @var string $path path to a directory in the container to extract the archive’s contents into
     * @var string $noOverwriteDirNonDir if `1`, `true`, or `True` then it will be an error if unpacking the
     *             given content would cause an existing directory to be replaced with
     *             a non-directory and vice versa
     * @var string $copyUIDGID If `1`, `true`, then it will copy UID/GID maps to the dest file or
     *             dir
     *
     * }
     */
    public function __construct(string $id, $inputStream, array $queryParameters = [])
    {
        $this->id = $id;
        $this->body = $inputStream;
        $this->queryParameters = $queryParameters;
    }

    public function getMethod(): string
    {
        return 'PUT';
    }

    public function getUri(): string
    {
        return str_replace(['{id}'], [$this->id], '/containers/{id}/archive');
    }

    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null): array
    {
        return [[], $this->body];
    }

    public function getExtraHeaders(): array
    {
        return ['Accept' => ['application/json']];
    }

    protected function getQueryOptionsResolver(): \Symfony\Component\OptionsResolver\OptionsResolver
    {
        $optionsResolver = parent::getQueryOptionsResolver();
        $optionsResolver->setDefined(['path', 'noOverwriteDirNonDir', 'copyUIDGID']);
        $optionsResolver->setRequired(['path']);
        $optionsResolver->setDefaults([]);
        $optionsResolver->addAllowedTypes('path', ['string']);
        $optionsResolver->addAllowedTypes('noOverwriteDirNonDir', ['string']);
        $optionsResolver->addAllowedTypes('copyUIDGID', ['string']);

        return $optionsResolver;
    }

    /**
     * @return null
     *
     * @throws \App\Service\Docker\Exception\PutContainerArchiveBadRequestException
     * @throws \App\Service\Docker\Exception\PutContainerArchiveForbiddenException
     * @throws \App\Service\Docker\Exception\PutContainerArchiveNotFoundException
     * @throws \App\Service\Docker\Exception\PutContainerArchiveInternalServerErrorException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return null;
        }
        if (400 === $status) {
            throw new \App\Service\Docker\Exception\PutContainerArchiveBadRequestException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (403 === $status) {
            throw new \App\Service\Docker\Exception\PutContainerArchiveForbiddenException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\PutContainerArchiveNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\PutContainerArchiveInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
