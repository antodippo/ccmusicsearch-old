<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\ServicePromise;
use App\Model\SongRecord;
use GuzzleHttp\ClientInterface;

class JamendoApiService implements ApiService
{
    public const SERVICE_NAME = 'jamendo';

    private ClientInterface $client;
    private string $baseUri;
    private string $apiKey;
    private int $limit;

    public function __construct(ClientInterface $client, string $baseUri, string $apiKey, int $limit)
    {
        $this->client = $client;
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;
        $this->limit = $limit;
    }

    public function getRequestPromises(array $filters): array
    {
        $uri = '?client_id=' . $this->apiKey .
            '&order=releasedate_desc' .
            '&format=json' .
            '&limit=' . $this->limit .
            '&tags=' . $filters['tag'];
        $promise = $this->client->requestAsync('GET', $this->baseUri . $uri);

        return [new ServicePromise(self::class, $promise)];
    }

    public function getSongRecords(string $response): array
    {
        $results = json_decode($response, true) ?: [];
        $songRecords = array();
        if (array_key_exists('results', $results)) {
            foreach($results['results'] as $song) {
                $songRecords[] = new SongRecord(
                    $song['artist_name'],
                    $song['name'],
                    date('i.s', $song['duration']),
                    new \DateTime($song['releasedate']),
                    $song['shareurl'],
                    $this->getLicenseCodeFromUrl($song['license_ccurl']),
                    self::SERVICE_NAME
                );
            }
        }

        return $songRecords;
    }

    private function getLicenseCodeFromUrl(string $licenseUrl): ?string
    {
        $licenseUrlArray = explode('/', $licenseUrl);
        return isset($licenseUrlArray[4]) ? $licenseUrlArray[4] : null;
    }
}