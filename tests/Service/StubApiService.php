<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Model\ServicePromise;
use App\Service\ApiService;
use App\Tests\Model\SongRecordStub;
use App\Tests\Model\PromiseStub;

class StubApiService implements ApiService
{
    public function getRequestPromises(array $filters): array
    {
        return [
            new ServicePromise('stub', new PromiseStub()),
            new ServicePromise('stub', new PromiseStub()),
        ];
    }

    public function getSongRecords(string $response): array
    {
        return [
            SongRecordStub::fromTitle('Strawberry fields forever'),
            SongRecordStub::fromTitle('Eleanor Rigby'),
        ];
    }
}