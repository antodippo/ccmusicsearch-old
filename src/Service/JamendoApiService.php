<?php

namespace App\Service;


use App\Model\SongRecord;

class JamendoApiService extends AbstractApiService
{

    public function getSongRecords(array $filters): array
    {
        $uri = '?client_id=' . $this->apiKey .
            '&order=releasedate_desc' .
            '&format=json' .
            '&limit=' . $this->limit .
            '&tags=' . $filters['tag'];
        $data = $this->apiClient->performRequest($this->baseUri, $uri);

        $songRecords = array();
        if (array_key_exists('results',$data)) {
            foreach($data['results'] as $song) {
                $songRecords[] = new SongRecord(
                    $song['artist_name'],
                    $song['name'],
                    date('i.s', $song['duration']),
                    new \DateTime($song['releasedate']),
                    $song['shareurl'],
                    $this->getLicenseCodFromUrl($song['license_ccurl']),
                    'jamendo'
                );
            }
        }

        return $songRecords;
    }
}