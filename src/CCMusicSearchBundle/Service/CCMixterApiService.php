<?php

namespace CCMusicSearchBundle\Service;


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
            $songRecords[] = array(
                'author'    => $song['user_name'],
                'title'     => $song['upload_name'],
                'duration'  => $formattedDuration,
                'date'      => \DateTime::createFromFormat('D, M j, Y @ g:i A', $song['upload_date_format']),
                'link'      => $song['file_page_url'],
                'license'   => $this->getLicenseCodFromUrl($song['license_url']),
                'service'   => 'ccmixter'
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