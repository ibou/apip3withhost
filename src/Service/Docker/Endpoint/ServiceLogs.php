<?php

namespace App\Service\Docker\Endpoint;

class ServiceLogs extends \App\Service\Docker\Runtime\Client\BaseEndpoint implements \App\Service\Docker\Runtime\Client\Endpoint
{
    use \App\Service\Docker\Runtime\Client\EndpointTrait;
    protected $id;

    /**
     * Get `stdout` and `stderr` logs from a service. See also
     * [`/containers/{id}/logs`](#operation/ContainerLogs).
     *
     **Note**: This endpoint works only for services with the `local`,
     * `json-file` or `journald` logging drivers.
     *
     * @param string $id              ID or name of the service
     * @param array  $queryParameters {
     *
     * @var bool   $details show service context and extra details provided to logs
     * @var bool   $follow keep connection after returning logs
     * @var bool   $stdout Return logs from `stdout`
     * @var bool   $stderr Return logs from `stderr`
     * @var int    $since Only return logs since this time, as a UNIX timestamp
     * @var bool   $timestamps Add timestamps to every log line
     * @var string $tail Only return this number of log lines from the end of the logs.
     *             Specify as an integer or `all` to output all log lines.
     *
     * }
     */
    public function __construct(string $id, array $queryParameters = [])
    {
        $this->id = $id;
        $this->queryParameters = $queryParameters;
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getUri(): string
    {
        return str_replace(['{id}'], [$this->id], '/services/{id}/logs');
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
        $optionsResolver->setDefined(['details', 'follow', 'stdout', 'stderr', 'since', 'timestamps', 'tail']);
        $optionsResolver->setRequired([]);
        $optionsResolver->setDefaults(['details' => false, 'follow' => false, 'stdout' => false, 'stderr' => false, 'since' => 0, 'timestamps' => false, 'tail' => 'all']);
        $optionsResolver->addAllowedTypes('details', ['bool']);
        $optionsResolver->addAllowedTypes('follow', ['bool']);
        $optionsResolver->addAllowedTypes('stdout', ['bool']);
        $optionsResolver->addAllowedTypes('stderr', ['bool']);
        $optionsResolver->addAllowedTypes('since', ['int']);
        $optionsResolver->addAllowedTypes('timestamps', ['bool']);
        $optionsResolver->addAllowedTypes('tail', ['string']);

        return $optionsResolver;
    }

    /**
     * @return null
     *
     * @throws \App\Service\Docker\Exception\ServiceLogsNotFoundException
     * @throws \App\Service\Docker\Exception\ServiceLogsInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ServiceLogsServiceUnavailableException
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            return json_decode($body);
        }
        if (404 === $status) {
            throw new \App\Service\Docker\Exception\ServiceLogsNotFoundException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (500 === $status) {
            throw new \App\Service\Docker\Exception\ServiceLogsInternalServerErrorException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
        if (503 === $status) {
            throw new \App\Service\Docker\Exception\ServiceLogsServiceUnavailableException($serializer->deserialize($body, 'App\\Service\\Docker\\Model\\ErrorResponse', 'json'), $response);
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
