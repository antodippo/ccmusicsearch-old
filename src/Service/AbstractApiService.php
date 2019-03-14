<?php

namespace App\Service;

abstract class AbstractApiService
{
    /** @var ApiClient */
    protected $apiClient;

    /** @var string */
    protected $baseUri;

    /** @var string */
    protected $apiKey;

    /** @var int */
    protected $limit;

    /** @var array */
    protected $licenses;

    public function __construct(ApiClient $apiClient, string $baseUri, string $apiKey, int $limit, array $licenses)
    {
        $this->apiClient = $apiClient;
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;
        $this->limit = $limit;
        $this->licenses = $licenses;
    }

    abstract public function getSongRecords(array $filters): array;

    public function getLicenseCodFromUrl($licenseUrl): ?string
    {
        $licenseUrlArray = explode('/', $licenseUrl);
        return isset($licenseUrlArray[4]) ? $licenseUrlArray[4] : null;
    }

}