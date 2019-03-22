<?php

namespace App\Service;

use App\Model\SongRecord;

class FreeMusicArchiveApiService extends AbstractApiService
{
    public function getSongRecords(array $filters): array
    {
        $genreUri = 'genres.xml?api_key=' . $this->apiKey;
        $genreData = $this->apiClient->performRequest($this->baseUri, $genreUri, true);

        if (array_key_exists('dataset', $genreData)) {
            $genresArray = array_filter($genreData['dataset']['value'],
                function($array) use ($filters) {
                    return strtolower($filters['tag']) ==  strtolower($array['genre_title']);
                }
            );
        } else {
            $genresArray = [];
        }

        $songRecords = [];

        if(count($genresArray)) {
            $genre = current($genresArray);
            $uri = 'tracks.xml?api_key=' . $this->apiKey .
                '&limit=' . $this->limit .
                '&genre_id=' . $genre['genre_id'] .
                '&sort_by=track_date_created&sort_dir=desc';
            $data = $this->apiClient->performRequest($this->baseUri, $uri, true);

            if (is_array($data) && array_key_exists('dataset', $data)) {
                foreach($data['dataset']['value'] as $song) {
                    if (is_string($song['track_url'])) {
                        $songRecords[] = new SongRecord(
                            $song['artist_name'],
                            $song['track_title'],
                            $this->formatDuration($song['track_duration']),
                            \DateTime::createFromFormat('m/d/Y h:i:s A', $song['track_date_created']),
                            $song['track_url'],
                            $this->licenseUrlToLicenseCode($song['license_url']),
                            'freemusicarchive'
                        );
                    }
                }
            }
        }

        return $songRecords;
    }

    public function formatDuration(string $duration): string
    {
        return substr_replace($duration, '.', 2, 1);
    }

    public function licenseUrlToLicenseCode(string $licenseUrl): ?string
    {
        $licenseUrlArray = explode('/', $licenseUrl);
        if(array_key_exists(4, $licenseUrlArray)) {
            return $licenseUrlArray[4];
        } else {
            return null;
        }
    }
}