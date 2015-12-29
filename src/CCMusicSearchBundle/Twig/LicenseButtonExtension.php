<?php

namespace CCMusicSearchBundle\Twig;

class LicenseButtonExtension extends \Twig_Extension
{
    protected $baseUrl;
    protected $baseImageUrl;
    protected $licenses;
    protected $logger;

    public function __construct($baseUrl, $baseImageUrl, $licenses, $logger)
    {
        $this->baseUrl = $baseUrl;
        $this->baseImageUrl = $baseImageUrl;
        $this->licenses = $licenses;
        $this->logger = $logger;
    }


    public function getName()
    {
        return 'license_button_extension';
    }

    public function getFunctions()
    {
        return array(
            'getButtonUrl' => new \Twig_SimpleFunction('getButtonUrl', array($this, 'getButtonUrl')),
            'getButtonImageUrl' => new \Twig_SimpleFunction('getButtonImageUrl', array($this, 'getButtonImageUrl'))
        );
    }

    public function getButtonUrl($license)
    {
        $license = str_replace('cc-', '', $license);
        if(!in_array($license, $this->licenses)) {
            $this->logger->error('License \'' . $license . '\' not found');
            return null;
        }

        return str_replace('license_type', $license, $this->baseUrl);
    }

    public function getButtonImageUrl($license)
    {
        $license = str_replace('cc-', '', $license);
        if(!in_array($license, $this->licenses)) {
            $this->logger->error('License \'' . $license . '\' not found');
            return null;
        }

        return str_replace('license_type', $license, $this->baseImageUrl);
    }

}