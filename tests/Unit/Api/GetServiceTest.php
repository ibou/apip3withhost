<?php

declare(strict_types=1);

namespace App\Tests\Unit\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetServiceTest extends WebTestCase
{
    public function testGetServiceCollection(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/api/services');
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->markTestIncomplete();
    }

}