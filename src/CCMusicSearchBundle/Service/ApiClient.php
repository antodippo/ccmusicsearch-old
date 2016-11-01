<?php

namespace CCMusicSearchBundle\Service;

use GuzzleHttp\Client;

class ApiClient implements ApiClientInterface
{
    protected $logger;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }


    public function performRequest($baseUri, $url, $xml = false)
    {
        try {
            $client = new Client(array('base_uri' => $baseUri));
            $data = $client->get($url)->getBody()->getContents();

            if($xml) {
                return json_decode(json_encode(simplexml_load_string($data)), true);
            } else {
                return json_decode($data, true);
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage() . ' (' . $baseUri . '/' . $url . ') ');
            return array();
        }

    }

}