<?php

namespace CCMusicSearchBundle\Service;


abstract class AbstractApiService
{
    protected $apiClient;
    protected $baseUri;
    protected $apiKey;
    protected $limit;
    protected $licenses;

    public function __construct($apiClient, $baseUri, $apiKey, $limit, $licenses)
    {
        $this->apiClient = $apiClient;
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;
        $this->limit = $limit;
        $this->licenses = $licenses;
    }

    abstract public function getSongRecords(array $filters);

    public function getLicenseCodFromUrl($licenseUrl)
    {
        $licenseUrlArray = explode('/', $licenseUrl);
        return isset($licenseUrlArray[4]) ? $licenseUrlArray[4] : null;
    }

}