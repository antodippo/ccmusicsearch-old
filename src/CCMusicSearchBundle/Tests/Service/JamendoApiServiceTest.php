<?php

namespace CCMusicSearchBundle\Tests\Service;


use CCMusicSearchBundle\Model\SongRecord;
use CCMusicSearchBundle\Service\JamendoApiService;

class JamendoApiServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testItGetsSongsRecord()
    {
        $rawSongArray = array(
            "headers" => array(
                "status" => "success",
                "code" => 0,
                "error_message" => "",
                "warnings" => "",
                "results_count" => 2,
            ),
            "results" => array(
                0 => array(
                    "id" => "256860",
                    "name" => "revealed",
                    "duration" => 191,
                    "artist_id" => "5860",
                    "artist_name" => "The fixer",
                    "artist_idstr" => "the.fixer",
                    "album_name" => "Nature in Motion",
                    "album_id" => "36821",
                    "license_ccurl" => "http://creativecommons.org/licenses/by-sa/3.0/",
                    "position" => 4,
                    "releasedate" => "2008-12-19",
                    "album_image" => "https://imgjam1.jamendo.com/albums/s36/36821/covers/1.200.jpg",
                    "audio" => "https://storage.jamendo.com/?trackid=256860&format=mp31&from=app-45f790fc",
                    "audiodownload" => "https://storage.jamendo.com/download/track/256860/mp32/",
                    "prourl" => "https://licensing.jamendo.com/track/256860",
                    "shorturl" => "http://jamen.do/t/256860",
                    "shareurl" => "http://www.jamendo.com/track/256860",
                    "image" => "https://imgjam1.jamendo.com/albums/s36/36821/covers/1.200.jpg"
                ),
                1 => array(
                    "id" => "256860",
                    "name" => "Test new title",
                    "duration" => 33,
                    "artist_id" => "5860",
                    "artist_name" => "The fixer",
                    "artist_idstr" => "the.fixer",
                    "album_name" => "Nature in Motion",
                    "album_id" => "36821",
                    "license_ccurl" => "http://creativecommons.org/licenses/by-sa/3.0/",
                    "position" => 4,
                    "releasedate" => "2008-12-19",
                    "album_image" => "https://imgjam1.jamendo.com/albums/s36/36821/covers/1.200.jpg",
                    "audio" => "https://storage.jamendo.com/?trackid=256860&format=mp31&from=app-45f790fc",
                    "audiodownload" => "https://storage.jamendo.com/download/track/256860/mp32/",
                    "prourl" => "https://licensing.jamendo.com/track/256860",
                    "shorturl" => "http://jamen.do/t/256860",
                    "shareurl" => "http://www.jamendo.com/track/256860",
                    "image" => "https://imgjam1.jamendo.com/albums/s36/36821/covers/1.200.jpg"
                )
            )
        );

        $expectedArray = array(
            0 => new SongRecord(
                'The fixer',
                'revealed',
                '03.11',
                new \DateTime('2008-12-19'),
                'http://www.jamendo.com/track/256860',
                'by-sa',
                'jamendo'
            ),
            1 => new SongRecord(
                'The fixer',
                'Test new title',
                '00.33',
                new \DateTime('2008-12-19'),
                'http://www.jamendo.com/track/256860',
                'by-sa',
                'jamendo'
            ),
        );

        $apiClient = \Phake::mock('CCMusicSearchBundle\Service\ApiClient');
        \Phake::when($apiClient)->performRequest(\Phake::anyParameters())->thenReturn($rawSongArray);

        $SUT = new JamendoApiService($apiClient, 'fake_uri', 'fake_key', 10, array('by'));
        $resultArray = $SUT->getSongRecords(array('tag' => 'fake_tag'));

        $this->assertEquals($expectedArray, $resultArray);
    }


    /**
     * @dataProvider licenseCodeFromUrlProvider
     */
    public function testItGetsLicenseCodeFromUrl($url, $license)
    {
        $apiClient = \Phake::mock('CCMusicSearchBundle\Service\ApiClient');
        $SUT = new JamendoApiService($apiClient, 'fake_uri', 'fake_key', 10, array('by'));
        $this->assertEquals($license, $SUT->getLicenseCodFromUrl($url));
    }

    public function licenseCodeFromUrlProvider()
    {
        return array(
            array('http://creativecommons.org/licenses/by-sa/3.0/', 'by-sa'),
            array('http://creativecommons.org/licenses/by/4.0/', 'by'),
            array('http://creativecommons.org/licenses/by-sa-nc/2.0/', 'by-sa-nc'),
            array('fake_url_string', null)
        );
    }

}
