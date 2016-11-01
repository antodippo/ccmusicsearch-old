<?php

namespace CCMusicSearchBundle\Service;


interface ApiClientInterface
{
    public function performRequest($baseUri, $url, $xml = false);
}