<?php

declare(strict_types=1);

namespace App\Model;

use GuzzleHttp\Promise\PromiseInterface;

class ServicePromise
{
    private string $serviceId;
    private PromiseInterface $promise;

    public function __construct(string $serviceId, PromiseInterface $promise)
    {
        $this->serviceId = $serviceId;
        $this->promise = $promise;
    }

    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    public function getResultBody(): string
    {
        return (string) $this->promise->wait()->getBody()->getContents();
    }
}