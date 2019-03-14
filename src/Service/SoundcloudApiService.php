<?php

namespace App\Service;


use App\Model\SongRecord;

class SoundcloudApiService extends AbstractApiService
{

    public function getSongRecords(array $filters): array
    {
        $data = [];
        foreach($this->licenses as $license) {
            $uri = '?client_id=' . $this->apiKey .
                '&limit=' . $this->limit .
                '&license=cc-' . $license .
                '&tags=' . $filters['tag'];
            $results = array_values((array)$this->apiClient->performRequest($this->baseUri, $uri));
            $data = array_merge($data, $results);
        }

        $songRecords = [];
        foreach($data as $song) {
            $songRecords[] = new SongRecord(
                $song['user']['username'],
                $song['title'],
                date('i.s', $song['duration']/1000),
                new \DateTime($song['created_at']),
                $song['permalink_url'],
                $song['license'],
                'soundcloud'
            );
        }

        return $songRecords;
    }
}