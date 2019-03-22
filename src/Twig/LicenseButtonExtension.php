<?php

namespace App\Twig;

use Psr\Log\LoggerInterface;
use Twig\Extension\AbstractExtension;

class LicenseButtonExtension extends AbstractExtension
{
    /** @var string */
    private $baseUrl;

    /** @var string */
    private $baseImageUrl;

    /** @var array */
    private $licenses;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(string $baseUrl, string $baseImageUrl, array $licenses, LoggerInterface $logger)
    {
        $this->baseUrl = $baseUrl;
        $this->baseImageUrl = $baseImageUrl;
        $this->licenses = $licenses;
        $this->logger = $logger;
    }

    public function getName(): string
    {
        return 'license_button_extension';
    }

    public function getFunctions(): array
    {
        return [
            'getButtonUrl' => new \Twig_Function('getButtonUrl', [$this, 'getButtonUrl']),
            'getButtonImageUrl' => new \Twig_Function('getButtonImageUrl', [$this, 'getButtonImageUrl'])
        ];
    }

    public function getButtonUrl(?string $license): ?string
    {
        $license = str_replace('cc-', '', $license);
        if(!in_array($license, $this->licenses)) {
            $this->logger->error('License \'' . $license . '\' not found');
            return 'https://creativecommons.org';
        }

        return str_replace('license_type', $license, $this->baseUrl);
    }

    public function getButtonImageUrl(?string $license): ?string
    {
        $license = str_replace('cc-', '', $license);
        if(!in_array($license, $this->licenses)) {
            $this->logger->error('License \'' . $license . '\' not found');
            return 'https://mirrors.creativecommons.org/presskit/cc.primary.srr.gif';
        }

        return str_replace('license_type', $license, $this->baseImageUrl);
    }

}