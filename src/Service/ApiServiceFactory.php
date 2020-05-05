<?php

declare(strict_types=1);

namespace App\Service;

class ApiServiceFactory
{
    private ApiService $jamendoApiService;
    private ApiService $soundcloudApiService;
    private ApiService $CCMixterApiService;
    private ApiService $icons8ApiService;

    public function __construct(
        ApiService $jamendoApiService,
        ApiService $soundcloudApiService,
        ApiService $CCMixterApiService,
        ApiService $icons8ApiService
    ) {
        $this->jamendoApiService = $jamendoApiService;
        $this->soundcloudApiService = $soundcloudApiService;
        $this->CCMixterApiService = $CCMixterApiService;
        $this->icons8ApiService = $icons8ApiService;
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
            case 'App\Service\Icons8ApiService':
                return $this->icons8ApiService;
            default;
                throw new \InvalidArgumentException('Service \'' . $serviceName . '\' does not exist');
        }
    }
}