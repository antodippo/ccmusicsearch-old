<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Model\ServicePromise;
use App\Model\SongRecord;
use App\Service\Icons8ApiService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;

class Icons8ApiServiceTest extends TestCase
{
    public function testItReturnsAnArrayOfPromises()
    {
        $client = \Phake::mock(ClientInterface::class);
        \Phake::when($client)
            ->requestAsync('GET', 'fake_base_url/?sort_by=created_at&per_page=2&filter=pop')
            ->thenReturn(\Phake::mock(PromiseInterface::class));

        $SUT = new Icons8ApiService($client, 'fake_base_url/', 2);
        $promises = $SUT->getRequestPromises(['tag' => 'pop']);

        $this->assertCount(1, $promises);
        $this->assertInstanceOf(ServicePromise::class, $promises[0]);
        $this->assertEquals(Icons8ApiService::class, $promises[0]->getServiceId());
    }

    public function testItReturnsSongRecords(): void
    {
        $expectedSongRecords = [
            0 => new SongRecord(
                'Ilya Truhanov',
                'Air',
                '00.44',
                '115',
                'acoustic folk calm carefree chill acoustic-drums acoustic-guitar percussion beach easy-listening ',
                new \DateTime('2017-12-28 12:04:20'),
                'https://icons8.com/music/author/ilya-truhanov-1',
                '',
                'icons8'
            ),
            1 => new SongRecord(
                'Ilya Truhanov',
                'Pancakes',
                '04.36',
                '120',
                'acoustic country folk beautiful calm acoustic-guitar beach ',
                new \DateTime('2017-12-28 12:18:42'),
                'https://icons8.com/music/author/ilya-truhanov-1',
                '',
                'icons8'
            ),
        ];

        $jsonResponse = file_get_contents(__DIR__ . '/responses/icons8.json');

        $client = \Phake::mock(ClientInterface::class);
        $SUT = new Icons8ApiService($client, 'fake_base_url/', 2);
        $songRecords = $SUT->getSongRecords($jsonResponse);

        $this->assertEquals($expectedSongRecords, $songRecords);
    }
}
