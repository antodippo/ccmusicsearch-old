<?php

namespace CCMusicSearchBundle\Service;


class JamendoApiService extends AbstractApiService
{

    public function getSongRecords(array $filters)
    {
        $uri = '?client_id=' . $this->apiKey .
            '&order=releasedate_desc' .
            '&format=json' .
            '&limit=' . $this->limit .
            '&tags=' . $filters['tag'];
        $data = $this->apiClient->performRequest($this->baseUri, $uri);

        $songRecords = array();
        foreach($data['results'] as $song) {
            $songRecords[] = array(
                'author'    => $song['artist_name'],
                'title'     => $song['name'],
                'duration'  => date('i.s', $song['duration']),
                'date'      => new \DateTime($song['releasedate']),
                'link'      => $song['shareurl'],
                'license'   => $this->getLicenseCodFromUrl($song['license_ccurl']),
                'service'   => 'jamendo'
            );
        }

        return $songRecords;
    }

}