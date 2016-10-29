<?php

namespace CCMusicSearchBundle\Service;


use CCMusicSearchBundle\Model\SongRecord;

class CCMixterApiService extends AbstractApiService
{

    public function getSongRecords(array $filters)
    {
        $uri = 'query?limit=' . $this->limit .
            '&f=json' .
            '&tags=' . $filters['tag'];
        $data = $this->apiClient->performRequest($this->baseUri, $uri);

        $songRecords = array();
        foreach($data as $song) {
            if(isset($song['files'][0]['file_format_info']['ps'])) {
                $formattedDuration = $this->formatDuration($song['files'][0]['file_format_info']['ps']);
            } else {
                $formattedDuration = null;
            }
            $songRecords[] = new SongRecord(
                $song['user_name'],
                $song['upload_name'],
                $formattedDuration,
                \DateTime::createFromFormat('D, M j, Y @ g:i A', $song['upload_date_format']),
                $song['file_page_url'],
                $this->getLicenseCodFromUrl($song['license_url']),
                'ccmixter'
            );
        }

        return $songRecords;
    }

    public function formatDuration($duration)
    {
        $durationArray = explode(':', $duration);
        if($durationArray[0] < 10) $durationArray[0] = '0' . $durationArray[0];
        return $durationArray[0] . '.' . $durationArray[1];
    }

}