<?php

namespace App\Tests\Integration\Docker;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\CurlHttpClient;

class DockerAcceptanceTest extends WebTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $client = (new CurlHttpClient([
//            'bindto' => '/var/run/docker.sock'
            'cafile' => __DIR__ . '/../../../ssl-test/ca.pem',
            'local_cert' => __DIR__ . '/../../../ssl-test/client.pem',
            'local_pk' => __DIR__ . '/../../../ssl-test/client.key',
//            'verify_host' => false,
        ]));
        $response = $client->request(
            'GET',
            'https://192.168.56.10:2376/version'
        );

        dump(
//            $client,
            $response->getStatusCode(),
            $response->getContent(),
        );

        $this->assertSame('test', $kernel->getEnvironment());
    }
}
