<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\ServicePromise;
use App\Model\SongRecord;
use GuzzleHttp\ClientInterface;

class Icons8ApiService implements ApiService
{
    public const SERVICE_NAME = 'icons8';

    private ClientInterface $client;
    private string $baseUri;
    private int $limit;

    public function __construct(ClientInterface $client, string $baseUri, int $limit)
    {
        $this->client = $client;
        $this->baseUri = $baseUri;
        $this->limit = $limit;
    }

    public function getRequestPromises(array $filters): array
    {
        $uri = '?sort_by=created_at&per_page=' . $this->limit . '&filter=' . $filters['tag'];
        $promise = $this->client->requestAsync('GET', $this->baseUri . $uri);

        return [new ServicePromise(self::class, $promise)];
    }

    public function getSongRecords(string $response): array
    {
        $results = json_decode($response, true) ?: [];
        $songRecords = [];
        if (array_key_exists('tracks', $results)) {
            foreach($results['tracks'] as $song) {
                $songRecords[] = new SongRecord(
                    $song['user']['name'],
                    $song['name'],
                    (string) date('i.s', intval($song['duration'])),
                    (string) $song['bpm'],
                    $this->getTags($song, 'genres', 'moods', 'instruments', 'tags'),
                    \DateTime::createFromFormat('U', (string) $song['created_at']),
                    'https://icons8.com/music/author/' . $song['user']['pretty_id'],
                    '',
                    self::SERVICE_NAME
                );
            }
        }

        return $songRecords;
    }

    private function getTags(array $song, string ...$tagTypes): string
    {
        $tags = '';
        foreach ($tagTypes as $tagType) {
            foreach ($song[$tagType] as $item) {
                $tags .= $item['pretty_id'] . ' ';
            }
        }

        return $tags;
    }
}