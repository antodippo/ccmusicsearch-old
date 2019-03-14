<?php

namespace App\Service;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class GuzzleApiClient implements ApiClient
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function performRequest(string $baseUri, string $url, bool $xml = false): array
    {
        try {
            $client = new Client(['base_uri' => $baseUri]);
            $data = $client->get($url)->getBody()->getContents();

            if($xml) {
                return json_decode(json_encode(simplexml_load_string($data)), true);
            } else {
                return json_decode($data, true) ?: [];
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage() . ' (' . $baseUri . '/' . $url . ') ');

            return [];
        }
    }
}