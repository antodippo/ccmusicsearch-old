<?php

namespace CCMusicSearchBundle\Service;


class ApiClientStub implements ApiClientInterface
{

    public function performRequest($baseUri, $url)
    {
        return [];
    }

}
