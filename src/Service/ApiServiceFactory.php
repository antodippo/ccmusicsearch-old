<?php

namespace App\Service;

class ApiServiceFactory
{
    /** @var JamendoApiService */
    private $jamendoApiService;

    /** @var SoundcloudApiService */
    private $soundcloudApiService;

    /** @var CCMixterApiService */
    private $CCMixterApiService;

    public function __construct(
        JamendoApiService $jamendoApiService,
        SoundcloudApiService $soundcloudApiService,
        CCMixterApiService $CCMixterApiService
    ) {
        $this->jamendoApiService = $jamendoApiService;
        $this->soundcloudApiService = $soundcloudApiService;
        $this->CCMixterApiService = $CCMixterApiService;
    }

    public function createService(string $serviceName): AbstractApiService
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