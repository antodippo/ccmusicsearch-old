<?php

declare(strict_types=1);

namespace App\Model;


class ServiceResult
{
    private string $serviceId;
    private string $resultBody;

    public function __construct(string $serviceId, string $resultBody)
    {
        $this->serviceId = $serviceId;
        $this->resultBody = $resultBody;
    }

    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    public function getResultBody(): string
    {
        return $this->resultBody;
    }
}