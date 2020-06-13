<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Model\ServicePromise;
use App\Model\SongRecord;
use App\Service\InternetArchiveApiService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;

class InternetArchiveApiServiceTest extends TestCase
{
    public function testItReturnsAnArrayOfPromises()
    {
        $client = \Phake::mock(ClientInterface::class);
        \Phake::when($client)
            ->requestAsync('GET', 'fake_base_url?rows=2&output=json&sort=createdate+desc&mediatype=audio&q=subject:pop')
            ->thenReturn(\Phake::mock(PromiseInterface::class));

        $SUT = new InternetArchiveApiService($client, 'fake_base_url', 2);
        $promises = $SUT->getRequestPromises(['tag' => 'pop']);

        $this->assertCount(1, $promises);
        $this->assertInstanceOf(ServicePromise::class, $promises[0]);
        $this->assertEquals(InternetArchiveApiService::class, $promises[0]->getServiceId());
    }

    public function testItReturnsSongRecords(): void
    {
        $expectedSongRecords = [
            0 => new SongRecord(
                'Natural Snow Buildings',
                'Natural Snow Buildings - Aldebaran [2016]',
                '',
                '',
                'drone psychedelic folk',
                new \DateTime('2020-06-13 03:42:56'),
                'https://archive.org/details/NaturalSnowBuildings-Aldebaran2016',
                'by-nc-nd',
                'internetarchive'
            ),
            1 => new SongRecord(
                'El Chata de Vicalvaro',
                'Cante de Levante',
                '',
                '',
                '78rpm Folk',
                new \DateTime('2020-06-13 00:00:43'),
                'https://archive.org/details/78_cante-de-levante-amores-no-ha-de-buscar',
                '',
                'internetarchive'
            ),
        ];

        $jsonResponse = file_get_contents(__DIR__ . '/responses/internetarchive.json');

        $client = \Phake::mock(ClientInterface::class);
        $SUT = new InternetArchiveApiService($client, 'fake_base_url/', 2);
        $songRecords = $SUT->getSongRecords($jsonResponse);

        $this->assertEquals($expectedSongRecords, $songRecords);
    }
}