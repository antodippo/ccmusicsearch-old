<?php

namespace App\Tests\Service;

use App\Service\ApiServiceFactory;
use App\Service\CCMixterApiService;
use App\Service\Icons8ApiService;
use App\Service\JamendoApiService;
use App\Service\SoundcloudApiService;
use PHPUnit\Framework\TestCase;

class ApiServiceFactoryTest extends TestCase
{
    /** @var ApiServiceFactory */
    private $apiServiceFactory;

    protected function setUp(): void
    {
        $this->apiServiceFactory = new ApiServiceFactory(
            \Phake::mock(JamendoApiService::class),
            \Phake::mock(SoundcloudApiService::class),
            \Phake::mock(CCMixterApiService::class),
            \Phake::mock(Icons8ApiService::class),
        );
    }

    public function testItCreatesApiServices()
    {
        $apiService = $this->apiServiceFactory->get('App\Service\JamendoApiService');
        $this->assertInstanceOf(JamendoApiService::class, $apiService);

        $apiService = $this->apiServiceFactory->get('App\Service\SoundcloudApiService');
        $this->assertInstanceOf(SoundcloudApiService::class, $apiService);

        $apiService = $this->apiServiceFactory->get('App\Service\CCMixterApiService');
        $this->assertInstanceOf(CCMixterApiService::class, $apiService);

        $apiService = $this->apiServiceFactory->get('App\Service\Icons8ApiService');
        $this->assertInstanceOf(Icons8ApiService::class, $apiService);
    }

    public function testItThrowsAnException()
    {
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('Service \'foo\' does not exist');
        $this->apiServiceFactory->get('foo');
    }
}