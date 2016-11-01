<?php

namespace CCMusicSearchBundle\Service;


class ApiClientStub implements ApiClientInterface
{

    public function performRequest($baseUri, $url, $xml = false)
    {
        return [];
    }

}
