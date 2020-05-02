<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\ServicePromise;
use App\Model\ServiceResult;
use App\Model\SongRecord;
use Psr\Log\LoggerInterface;

class SearchPerformer
{
    private ApiServiceFactory $apiServiceFactory;
    private LoggerInterface $logger;
    private array $apiServices;

    public function __construct(ApiServiceFactory $apiServiceFactory, LoggerInterface $logger, array $apiServices)
    {
        $this->apiServiceFactory = $apiServiceFactory;
        $this->apiServices = $apiServices;
        $this->logger = $logger;
    }

    /**
     * @param array<string,string> $filters
     * @return SongRecord[]
     */
    public function search(array $filters): array
    {
        $servicePromises = [];
        foreach ($this->apiServices as $serviceId) {
            try {
                /** @var ServicePromise[] $servicePromises */
                $servicePromises = array_merge(
                    $servicePromises,
                    $this->apiServiceFactory->get($serviceId)->getRequestPromises($filters)
                );
            } catch (\Throwable $e) {
                $this->logger->error($serviceId . ' promise error: ' . $e->getMessage());
            }
        }

        $serviceResults = [];
        foreach ($servicePromises as $servicePromise) {
            try {
                $serviceResults[] = new ServiceResult(
                    $servicePromise->getServiceId(),
                    $servicePromise->getResultBody()
                );
            } catch (\Throwable $e) {
                $this->logger->error($servicePromise->getServiceId() . ' unwrap error: ' . $e->getMessage());
            }
        }

        $songs = [];
        foreach ($serviceResults as $serviceResult) {
            try {
                $songs = array_merge(
                    $songs,
                    $this->apiServiceFactory
                        ->get($serviceResult->getServiceId())
                        ->getSongRecords($serviceResult->getResultBody())
                );
            } catch (\Throwable $e) {
                $this->logger->error($serviceResult->getServiceId() . ' song record error: ' . $e->getMessage());
            }
        }

        return $songs;
    }
}