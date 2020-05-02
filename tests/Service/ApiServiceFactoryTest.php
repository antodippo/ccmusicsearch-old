<?php

namespace App\Tests\Service;

use App\Service\ApiServiceFactory;
use App\Service\CCMixterApiService;
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
        );
    }

    public function testItCreatesApiServices()
    {
        $apiService = $this->apiServiceFactory->createService('App\Service\JamendoApiService');
        $this->assertTrue($apiService instanceof JamendoApiService);

        $apiService = $this->apiServiceFactory->createService('App\Service\SoundcloudApiService');
        $this->assertTrue($apiService instanceof SoundcloudApiService);

        $apiService = $this->apiServiceFactory->createService('App\Service\CCMixterApiService');
        $this->assertTrue($apiService instanceof CCMixterApiService);
    }

    public function testItThrowsAnException()
    {
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('Service \'foo\' does not exist');
        $this->apiServiceFactory->createService('foo');
    }
}