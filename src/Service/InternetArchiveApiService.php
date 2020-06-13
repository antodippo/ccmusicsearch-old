<?php

declare(strict_types=1);

namespace App\Service;


use App\Model\ServicePromise;
use App\Model\SongRecord;
use GuzzleHttp\ClientInterface;

class InternetArchiveApiService implements ApiService
{
    public const SERVICE_NAME = 'internetarchive';

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
        $uri = '?rows=' . $this->limit . '&output=json&sort=createdate+desc&mediatype=audio&q=subject:' . $filters['tag'];
        $promise = $this->client->requestAsync('GET', $this->baseUri . $uri);

        return [new ServicePromise(self::class, $promise)];
    }

    public function getSongRecords(string $response): array
    {
        $results = json_decode($response, true) ?: [];
        $songRecords = [];
        foreach($results['response']['docs'] as $song) {
            $songRecords[] = new SongRecord(
                $this->getCreator($song['creator']),
                $song['title'],
                '',
                '',
                implode(' ', $song['subject']),
                new \DateTime($song['reviewdate']),
                'https://archive.org/details/' . $song['identifier'],
                isset($song['licenseurl']) ? $this->getLicenseCodeFromUrl($song['licenseurl']) : '',
                self::SERVICE_NAME
            );
        }

        return $songRecords;
    }

    /**
     * @param array|string $creator
     * @return string
     */
    private function getCreator($creator): string
    {
       if (is_array($creator)) {
           return $creator[0];
       }

       return $creator;
    }

    private function getLicenseCodeFromUrl(string $licenseUrl): string
    {
        $licenseUrlArray = explode('/', $licenseUrl);
        return isset($licenseUrlArray[4]) ? $licenseUrlArray[4] : '';
    }
}