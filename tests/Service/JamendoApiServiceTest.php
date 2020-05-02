<?php

namespace App\Tests\Service;

use App\Model\ServicePromise;
use App\Model\SongRecord;
use App\Service\JamendoApiService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;

class JamendoApiServiceTest extends TestCase
{
    public function testItReturnsAnArrayOfPromises()
    {
        $client = \Phake::mock(ClientInterface::class);
        \Phake::when($client)
            ->requestAsync('GET', 'fake_base_url/?client_id=fake_api_key&order=releasedate_desc&format=json&limit=2&tags=pop')
            ->thenReturn(\Phake::mock(PromiseInterface::class));

        $SUT = new JamendoApiService($client, 'fake_base_url/', 'fake_api_key', 2);
        $promises = $SUT->getRequestPromises(['tag' => 'pop']);

        $this->assertCount(1, $promises);
        $this->assertInstanceOf(ServicePromise::class, $promises[0]);
        $this->assertEquals(JamendoApiService::class, $promises[0]->getServiceId());
    }

    public function testItReturnsSongRecords(): void
    {
        $expectedSongRecords = [
            0 => new SongRecord(
                'Arnold Wohler',
                'Old man corona-Blues',
                '02.40',
                new \DateTime('2020-05-02 00:00:00'),
                'https://www.jamendo.com/track/1760388',
                'by-sa',
                'jamendo'
            ),
            1 => new SongRecord(
                'Agnes',
                'Znajdź swój blask',
                '03.15',
                new \DateTime('2020-05-01 00:00:00'),
                'https://www.jamendo.com/track/1759840',
                'by-nc-nd',
                'jamendo'
            ),
        ];

        $jsonResponse = file_get_contents(__DIR__ . '/responses/jamendo.json');

        $client = \Phake::mock(ClientInterface::class);
        $SUT = new JamendoApiService($client, 'fake_base_url/', 'fake_api_key', 2);
        $songRecords = $SUT->getSongRecords($jsonResponse);

        $this->assertEquals($expectedSongRecords, $songRecords);
    }
}
