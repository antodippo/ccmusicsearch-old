<?php

namespace App\Tests\Service;

use App\Model\ServicePromise;
use App\Model\SongRecord;
use App\Service\SoundcloudApiService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;

class SoundcloudApiServiceTest extends TestCase
{
    public function testItReturnsAnArrayOfPromises()
    {
        $client = \Phake::mock(ClientInterface::class);
        \Phake::when($client)
            ->requestAsync('GET', 'fake_base_url/?client_id=fake_api_key&limit=2&license=cc-by&tags=pop')
            ->thenReturn(\Phake::mock(PromiseInterface::class));
        \Phake::when($client)
            ->requestAsync('GET', 'fake_base_url/?client_id=fake_api_key&limit=2&license=cc-by-sa&tags=pop')
            ->thenReturn(\Phake::mock(PromiseInterface::class));

        $SUT = new SoundcloudApiService($client, 'fake_base_url/', 'fake_api_key', 2, ['by', 'by-nc', 'by-sa']);
        $promises = $SUT->getRequestPromises(['tag' => 'pop']);

        $this->assertCount(2, $promises);
        $this->assertInstanceOf(ServicePromise::class, $promises[0]);
        $this->assertInstanceOf(ServicePromise::class, $promises[1]);
        $this->assertEquals(SoundcloudApiService::class, $promises[0]->getServiceId());
        $this->assertEquals(SoundcloudApiService::class, $promises[1]->getServiceId());
    }

    public function testItReturnsSongRecords(): void
    {
        $expectedSongRecords = [
            0 => new SongRecord(
                'REPOST',
                'Marília Mendonça – Amante Não Tem Lar',
                '03.03',
                new \DateTime('2017-01-14 18:27:05'),
                'https://soundcloud.com/repost-promonetwork/marilia-mendonca-amante-nao-tem-lar',
                'cc-by-nc-sa',
                'soundcloud'
            ),
            1 => new SongRecord(
                'REPOST',
                'REPOST to 150.000 Followers! (PROMOTION) Link in description',
                '03.27',
                new \DateTime('2017-02-10 21:55:22'),
                'https://soundcloud.com/repost-promonetwork/repost-submit-your-track',
                'cc-by-nc-sa',
                'soundcloud'
            )
        ];

        $jsonResponse = file_get_contents(__DIR__ . '/responses/soundcloud.json');

        $client = \Phake::mock(ClientInterface::class);
        $SUT = new SoundcloudApiService($client, 'fake_base_url/', 'fake_api_key', 2, ['by']);
        $songRecords = $SUT->getSongRecords($jsonResponse);

        $this->assertEquals($expectedSongRecords, $songRecords);
    }
}
