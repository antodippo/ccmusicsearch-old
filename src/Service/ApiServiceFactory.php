<?php

declare(strict_types=1);

namespace App\Service;

class ApiServiceFactory
{
    private ApiService $jamendoApiService;
    private ApiService $soundcloudApiService;
    private ApiService $CCMixterApiService;

    public function __construct(
        ApiService $jamendoApiService,
        ApiService $soundcloudApiService,
        ApiService $CCMixterApiService
    ) {
        $this->jamendoApiService = $jamendoApiService;
        $this->soundcloudApiService = $soundcloudApiService;
        $this->CCMixterApiService = $CCMixterApiService;
    }

    public function get(string $serviceName): ApiService
    {
        switch ($serviceName) {
            case 'App\Service\JamendoApiService':
                return $this->jamendoApiService;
            case 'App\Service\SoundcloudApiService':
                return $this->soundcloudApiService;
            case 'App\Service\CCMixterApiService':
                return $this->CCMixterApiService;
            default;
                throw new \InvalidArgumentException('Service \'' . $serviceName . '\' does not exist');
        }
    }
}