<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\ServicePromise;
use App\Model\SongRecord;
use GuzzleHttp\ClientInterface;

class SoundcloudApiService implements ApiService
{
    public const SERVICE_NAME = 'soundcloud';

    private ClientInterface $client;
    private string $baseUri;
    private string $apiKey;
    private int $limit;
    private array $licenses;

    public function __construct(ClientInterface $client, string $baseUri, string $apiKey, int $limit, array $licenses)
    {
        $this->client = $client;
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;
        $this->limit = $limit;
        $this->licenses = $licenses;
    }

    public function getRequestPromises(array $filters): array
    {
        $promises = [];
        foreach($this->licenses as $license) {
            // because of this:
            // https://stackoverflow.com/questions/34978178/soundcloud-tracks-api-with-license-cc-by-nc-returning-400-bad-request
            if ($license === 'by-nc') continue;

            $uri = '?client_id=' . $this->apiKey .
                '&limit=' . $this->limit .
                '&license=cc-' . $license .
                '&tags=' . $filters['tag'];
            $promises[] = new ServicePromise(
                self::class,
                $this->client->requestAsync('GET', $this->baseUri . $uri)
            );
        }

        return $promises;
    }

    public function getSongRecords(string $response): array
    {
        $results = json_decode($response, true) ?: [];
        $songRecords = [];
        foreach($results as $result) {
            $songRecords[] = new SongRecord(
                $result['user']['username'],
                $result['title'],
                (string) date('i.s', intval($result['duration']/1000)),
                (string) $result['bpm'] ?? '',
                new \DateTime($result['created_at']),
                $result['permalink_url'],
                $result['license'],
                self::SERVICE_NAME
            );
        }

        return $songRecords;
    }
}