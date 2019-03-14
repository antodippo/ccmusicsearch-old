<?php

namespace App\Service;


interface ApiClient
{
    public function performRequest(string $baseUri, string $url, bool $xml = false): array;
}