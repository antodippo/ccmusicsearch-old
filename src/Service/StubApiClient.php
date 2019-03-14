<?php

namespace App\Service;


class StubApiClient implements ApiClient
{
    public function performRequest(string $baseUri, string $url, bool $xml = false): array
    {
        return [];
    }
}
