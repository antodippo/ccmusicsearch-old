<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\ServicePromise;
use App\Model\SongRecord;

interface ApiService
{
    /**
     * @param array $filters
     * @return ServicePromise[]
     */
    public function getRequestPromises(array $filters): array;

    /**
     * @param string $response
     * @return SongRecord[]
     */
    public function getSongRecords(string $response): array;
}