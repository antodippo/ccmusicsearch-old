<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\ServicePromise;
use App\Model\SongRecord;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;

class CCMixterApiService implements ApiService
{
    public const SERVICE_NAME = 'ccmixter';

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
        $uri = 'query?limit=' . $this->limit .
            '&f=json' .
            '&tags=' . $filters['tag'];
        $promise = $this->client->requestAsync('GET',$this->baseUri . $uri);

        return [new ServicePromise(self::class, $promise)];
    }

    public function getSongRecords(string $response): array
    {
        $results = json_decode($response, true) ?: [];
        $songRecords = [];
        foreach($results as $result) {
            if(isset($result['files'][0]['file_format_info']['ps'])) {
                $formattedDuration = $this->formatDuration($result['files'][0]['file_format_info']['ps']);
            } else {
                $formattedDuration = null;
            }
            $songRecords[] = new SongRecord(
                $result['user_name'],
                $result['upload_name'],
                $formattedDuration,
                \DateTime::createFromFormat('D, M j, Y @ g:i A', $result['upload_date_format']),
                $result['file_page_url'],
                $this->getLicenseCodeFromUrl($result['license_url']),
                self::SERVICE_NAME
            );
        }

        return $songRecords;
    }

    private function formatDuration(string $duration): string
    {
        $durationArray = explode(':', $duration);
        if($durationArray[0] < 10) $durationArray[0] = '0' . $durationArray[0];

        return $durationArray[0] . '.' . $durationArray[1];
    }

    private function getLicenseCodeFromUrl(string $licenseUrl): ?string
    {
        $licenseUrlArray = explode('/', $licenseUrl);
        return isset($licenseUrlArray[4]) ? $licenseUrlArray[4] : null;
    }
}