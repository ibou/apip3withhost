<?php

declare(strict_types=1);

namespace App\Tests\Unit\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetServiceTest extends WebTestCase
{
    use JsonAssertTrait;

    public function testGetServiceCollection(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/api/service');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertJsonSchema(
            [
                'type' => 'array',
                'items' => [
                    'type' => 'object',
                    'properties' => [
                        'uuid' => 'string',
                        'name' => 'string',
                        'type' => 'string',
                        'status' => 'string',
                        'location' => [
                            'type' => 'object',
                            'properties' => [
                                'name' => 'string',
                                'country' => 'string',
                                'type' => 'string'
                            ],
                        ],
                        'properties' => [
                            'type' => 'object',
                            'properties' => [
                                'slots' => 'integer',
                                'mapGroup' => 'string',
                                'map' => 'string',
                                'tickrate' => 'integer',
                                'vac' => 'boolean',
                            ]
                        ]
                    ],
                ],
            ],
            $client->getResponse()->getContent()
        );
    }

}
