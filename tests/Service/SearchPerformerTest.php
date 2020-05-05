<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\ApiServiceFactory;
use App\Service\SearchPerformer;
use App\Tests\Model\SongRecordStub;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class SearchPerformerTest extends TestCase
{
    public function testSearch()
    {
        $logger = \Phake::mock(LoggerInterface::class);
        $apiServiceFactory = \Phake::mock(ApiServiceFactory::class);
        \Phake::when($apiServiceFactory)->get(\Phake::anyParameters())->thenReturn(new StubApiService());

        $SUT = new SearchPerformer($apiServiceFactory, $logger, ['foo', 'bar']);
        $songs = $SUT->search(['tag' => 'Beatles']);

        $expectedSongs = [
            SongRecordStub::fromTitle('Strawberry fields forever'),
            SongRecordStub::fromTitle('Eleanor Rigby'),
            SongRecordStub::fromTitle('Strawberry fields forever'),
            SongRecordStub::fromTitle('Eleanor Rigby'),
            SongRecordStub::fromTitle('Strawberry fields forever'),
            SongRecordStub::fromTitle('Eleanor Rigby'),
            SongRecordStub::fromTitle('Strawberry fields forever'),
            SongRecordStub::fromTitle('Eleanor Rigby'),
        ];
        $this->assertEquals($expectedSongs, $songs);
    }
}
