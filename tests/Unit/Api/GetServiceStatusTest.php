<?php

declare(strict_types=1);

namespace App\Tests\Unit\Api;

use App\Entity\Service\ServiceStatusEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetServiceStatusTest extends WebTestCase
{
    public function testGetStatusCollection(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/api/service-status');
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();

        foreach ($response as $statusString)
        {
            $this->checkStatusString($statusString);
        }
    }

    public function testCompareWithEntity(): void
    {
        foreach (\App\ApiResource\ServiceStatusEnum::getCases() as $status)
        {
            $this->checkStatusString($status);
        }
    }

    private function checkStatusString(mixed $statusString): void
    {
        try {
            $status = ServiceStatusEnum::from($statusString);
        } catch (\ValueError) {
        }

        $this->assertInstanceOf(ServiceStatusEnum::class, $status);
    }
}