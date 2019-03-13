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

    /** @var FreeMusicArchiveApiService */
    private $freeMusicArchiveApiService;

    public function __construct(
        JamendoApiService $jamendoApiService,
        SoundcloudApiService $soundcloudApiService,
        CCMixterApiService $CCMixterApiService,
        FreeMusicArchiveApiService $freeMusicArchiveApiService
    ) {

        $this->jamendoApiService = $jamendoApiService;
        $this->soundcloudApiService = $soundcloudApiService;
        $this->CCMixterApiService = $CCMixterApiService;
        $this->freeMusicArchiveApiService = $freeMusicArchiveApiService;
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
            case 'App\Service\FreeMusicArchiveApiService':
                return $this->freeMusicArchiveApiService;
            default;
                throw new \InvalidArgumentException('Service \'' . $serviceName . '\' does not exist');
        }
    }
}