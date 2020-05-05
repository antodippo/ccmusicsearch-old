<?php

namespace App\Tests\Service;

use App\Model\ServicePromise;
use App\Model\SongRecord;
use App\Service\CCMixterApiService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;

class CCMixterApiServiceTest extends TestCase
{
    public function testItReturnsAnArrayOfPromises()
    {
        $client = \Phake::mock(ClientInterface::class);
        \Phake::when($client)
            ->requestAsync('GET', 'fake_base_url/query?limit=2&f=json&tags=pop')
            ->thenReturn(\Phake::mock(PromiseInterface::class));

        $SUT = new CCMixterApiService($client, 'fake_base_url/', 2);
        $promises = $SUT->getRequestPromises(['tag' => 'pop']);

        $this->assertCount(1, $promises);
        $this->assertInstanceOf(ServicePromise::class, $promises[0]);
        $this->assertEquals(CCMixterApiService::class, $promises[0]->getServiceId());
    }

    public function testItReturnsSongRecords(): void
    {
        $expectedSongRecords = [
            0 => new SongRecord(
                'Reiswerk',
                'Luwan House feat Sonja V',
                '02.28',
                '123',
                'dance,pop,house,deep,vocals',
                new \DateTime('2014-07-01 09:21:00'),
                'http://ccmixter.org/files/Reiswerk/46456',
                'by-nc',
                'ccmixter'
            ),
            1 => new SongRecord(
                'JeffSpeed68',
                'Procrastinating_in_The_Sun',
                '02.58',
                '151',
                'male_vocals,drums,guitar,bass,synthesizer,rock,pop',
                new \DateTime('2014-06-27 17:22:00'),
                'http://ccmixter.org/files/JeffSpeed68/46416',
                'by',
                'ccmixter'
            ),
        ];

        $jsonResponse = file_get_contents(__DIR__ . '/responses/ccmixter.json');

        $client = \Phake::mock(ClientInterface::class);
        $SUT = new CCMixterApiService($client, 'fake_base_url/', 2);
        $songRecords = $SUT->getSongRecords($jsonResponse);

        $this->assertEquals($expectedSongRecords, $songRecords);
    }
}
