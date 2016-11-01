<?php

namespace CCMusicSearchBundle\Tests\Service;


use CCMusicSearchBundle\Model\SongRecord;
use CCMusicSearchBundle\Service\FreeMusicArchiveApiService;

class FreeMusicArchiveApiServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testItGetsSongsRecord()
    {
        $rawGenresArray = array (
            'title' => 'Free Music Archive - Genres',
            'message' =>
                array (
                ),
            'errors' =>
                array (
                ),
            'total' => '163',
            'total_pages' => '9',
            'page' => '1',
            'limit' => '20',
            'dataset' =>
                array (
                    'value' =>
                        array (
                            0 =>
                                array (
                                    'genre_id' => '1',
                                    'genre_parent_id' => '38',
                                    'genre_title' => 'Avant-Garde',
                                    'genre_handle' => 'Avant-Garde',
                                    'genre_color' => '#006666',
                                ),
                            1 =>
                                array (
                                    'genre_id' => '2',
                                    'genre_parent_id' => array (),
                                    'genre_title' => 'International',
                                    'genre_handle' => 'International',
                                    'genre_color' => '#CC3300',
                                ),
                            2 =>
                                array (
                                    'genre_id' => '3',
                                    'genre_parent_id' => array (),
                                    'genre_title' => 'Blues',
                                    'genre_handle' => 'Blues',
                                    'genre_color' => '#000099',
                                ),
                            16 =>
                                array (
                                    'genre_id' => '17',
                                    'genre_parent_id' => array (),
                                    'genre_title' => 'Folk',
                                    'genre_handle' => 'Folk',
                                    'genre_color' => '#5E6D3F',
                                ),
                        ),
                ),
        );

        $rawSongsArray = array (
            'title' => 'Free Music Archive - Tracks',
            'message' =>
                array (
                ),
            'errors' =>
                array (
                ),
            'total' => '6749',
            'total_pages' => '225',
            'page' => '1',
            'limit' => '30',
            'dataset' =>
                array (
                    'value' =>
                        array (
                            0 =>
                                array (
                                    'track_id' => '145633',
                                    'track_title' => 'Sad walk with sad melodica',
                                    'track_url' => 'http://freemusicarchive.org/music/Komiku/Its_time_for_adventure__vol_2/Komiku_-_Its_time_for_adventure_vol_2_-_14_Sad_walk_with_sad_melodica',
                                    'track_image_file' => 'https://freemusicarchive.org/file/images/tracks/Track_-_20161101121441928',
                                    'artist_id' => '22473',
                                    'artist_name' => 'Komiku',
                                    'artist_url' => 'http://freemusicarchive.org/music/Komiku/',
                                    'artist_website' =>
                                        array (
                                        ),
                                    'album_id' => '21759',
                                    'album_title' => 'It\'s time for adventure ! vol 2',
                                    'album_url' => 'http://freemusicarchive.org/music/Komiku/Its_time_for_adventure__vol_2/',
                                    'license_title' => 'CC0 1.0 Universal',
                                    'license_url' => 'http://creativecommons.org/publicdomain/cc-by/1.0/',
                                    'track_language_code' =>
                                        array (
                                        ),
                                    'track_duration' => '03:11',
                                    'track_number' => '14',
                                    'track_disc_number' => '1',
                                    'track_explicit' =>
                                        array (
                                        ),
                                    'track_explicit_notes' =>
                                        array (
                                        ),
                                    'track_copyright_c' =>
                                        array (
                                        ),
                                    'track_copyright_p' =>
                                        array (
                                        ),
                                    'track_composer' =>
                                        array (
                                        ),
                                    'track_lyricist' =>
                                        array (
                                        ),
                                    'track_publisher' =>
                                        array (
                                        ),
                                    'track_instrumental' => '0',
                                    'track_information' =>
                                        array (
                                        ),
                                    'track_date_recorded' =>
                                        array (
                                        ),
                                    'track_comments' => '0',
                                    'track_favorites' => '0',
                                    'track_listens' => '54',
                                    'track_interest' => '72',
                                    'track_bit_rate' => '320000',
                                    'track_date_created' => '11/01/2016 11:48:21 AM',
                                    'track_file' => 'music/no_curator/Komiku/Its_time_for_adventure__vol_2/Komiku_-_14_-_Sad_walk_with_sad_melodica.mp3',
                                    'license_image_file' => 'http://i.creativecommons.org/p/cc-by/1.0/88x31.png',
                                    'license_image_file_large' => 'http://fma-files.s3.amazonaws.com/resources/img/licenses/cc-by.png',
                                    'license_parent_id' => '10',
                                    'tags' =>
                                        array (
                                        ),
                                    'track_genres' =>
                                        array (
                                            'value' =>
                                                array (
                                                    0 =>
                                                        array (
                                                            'genre_id' => '17',
                                                            'genre_title' => 'Folk',
                                                            'genre_url' => 'http://freemusicarchive.org/genre/Folk/',
                                                        ),
                                                    1 =>
                                                        array (
                                                            'genre_id' => '18',
                                                            'genre_title' => 'Soundtrack',
                                                            'genre_url' => 'http://freemusicarchive.org/genre/Soundtrack/',
                                                        ),
                                                    2 =>
                                                        array (
                                                            'genre_id' => '38',
                                                            'genre_title' => 'Experimental',
                                                            'genre_url' => 'http://freemusicarchive.org/genre/Experimental/',
                                                        ),
                                                ),
                                        ),
                                ),
                        ),
                ),
        );

        $expectedArray = array(
            new SongRecord(
                'Komiku',
                'Sad walk with sad melodica',
                '03.11',
                new \DateTime('01-11-2016 11:48:21'),
                'http://freemusicarchive.org/music/Komiku/Its_time_for_adventure__vol_2/Komiku_-_Its_time_for_adventure_vol_2_-_14_Sad_walk_with_sad_melodica',
                'cc-by',
                'freemusicarchive'
            ),
        );

        $apiClient = \Phake::mock('CCMusicSearchBundle\Service\ApiClient');
        \Phake::when($apiClient)
            ->performRequest(
                'fake_uri',
                'genres.xml?api_key=fake_key',
                true)
            ->thenReturn($rawGenresArray);

        \Phake::when($apiClient)
            ->performRequest(
                'fake_uri',
                'tracks.xml?api_key=fake_key&limit=10&genre_id=17&sort_by=track_date_created&sort_dir=desc',
                true)
            ->thenReturn($rawSongsArray);

        $SUT = new FreeMusicArchiveApiService($apiClient, 'fake_uri', 'fake_key', 10, array('by'));
        $resultArray = $SUT->getSongRecords(array('tag' => 'folk'));

        $this->assertEquals($expectedArray, $resultArray);
    }

    /**
     * @dataProvider licenses
     */
    public function testItExtractsLicenseCodes($licenseUrl, $licenseCode)
    {
        $apiClient = \Phake::mock('CCMusicSearchBundle\Service\ApiClient');
        $SUT = new FreeMusicArchiveApiService($apiClient, 'fake_uri', 'fake_key', 10, array('by'));
        $this->assertEquals($licenseCode, $SUT->licenseUrlToLicenseCode($licenseUrl));
    }

    public function licenses()
    {
        return array(
            array('http://creativecommons.org/licenses/by-nc-nd/3.0/', 'by-nc-nd'),
            array('http://creativecommons.org/licenses/by/3.0/', 'by'),
        );
    }

    /**
     * @dataProvider durations
     */
    public function testItFormatsDuration($duration, $formattedDuration)
    {
        $apiClient = \Phake::mock('CCMusicSearchBundle\Service\ApiClient');
        $SUT = new FreeMusicArchiveApiService($apiClient, 'fake_uri', 'fake_key', 10, array('by'));
        $this->assertEquals($formattedDuration, $SUT->formatDuration($duration));
    }

    public function durations()
    {
        return array(
            array('02:30', '02.30'),
            array('12:30', '12.30'),
            array('00:30', '00.30')
        );
    }

}
