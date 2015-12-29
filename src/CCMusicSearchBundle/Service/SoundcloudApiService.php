<?php

namespace CCMusicSearchBundle\Service;


class SoundcloudApiService extends AbstractApiService
{

    public function getSongRecords(array $filters)
    {

        $data = array();
        foreach($this->licenses as $license) {
            $uri = '?client_id=' . $this->apiKey .
                '&limit=' . $this->limit .
                '&license=cc-' . $license .
                '&tags=' . $filters['tag'];
            $results = array_values((array)$this->apiClient->performRequest($this->baseUri, $uri));
            $data = array_merge($data, $results);
        }

        $songRecords = array();
        foreach($data as $song) {
            $songRecords[] = array(
                'author'    => $song['user']['username'],
                'title'     => $song['title'],
                'duration'  => date('i.s', $song['duration']/1000),
                'date'      => new \DateTime($song['created_at']),
                'link'      => $song['permalink_url'],
                'license'   => $song['license'],
                'service'   => 'soundcloud'
            );
        }

        return $songRecords;
    }

}