<?php

namespace CCMusicSearchBundle\Tests\Service;


use CCMusicSearchBundle\Service\CCMixterApiService;

class CCMixterApiServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testItGetsSongsRecord()
    {
        $rawSongArray = array(
            array(
                "upload_id" => 52456,
                "upload_name" => "Mirror (New Acapella Mix)",
                "user_name" => "Reiswerk",
                "upload_tags" => ",media,remix,bpm_105_110,sample,non_commercial,audio,mp3,44k,stereo,CBR,folk",
                "file_page_url" => "http//ccmixter.org/files/Reiswerk/52456",
                "user_real_name" => "reiswerk",
                "artist_page_url" => "http//ccmixter.org/people/Reiswerk",
                "license_logo_url" => "http//ccmixter.org/ccskins/shared/images/lics/small-by-nc-3.png",
                "license_url" => "http//creativecommons.org/licenses/by-nc/3.0/",
                "license_name" => "Attribution Noncommercial  (3.0)",
                "upload_date_format" => "Sat, Dec 12, 2015 @ 2:05 AM",
                "files" => array(
                    array(
                        "file_format_info" => array(
                            "ps" => "3:14"
                        )
                    )
                ),
                "upload_description_plain" => "Blue Sevvin, I hope you will permit me to sing along..."
            ),
            array(
                "upload_id" => 52419,
                "upload_name" => "Snowman",
                "user_name" => "JeffSpeed68",
                "upload_tags" => ",lights_of_winter,remix,media,ccplus,bpm_175_180,non_commercial,audio,mp3,48k",
                "file_page_url" => "http//ccmixter.org/files/JeffSpeed68/52419",
                "user_real_name" => "Stefan Kartenberg",
                "artist_page_url" => "http//ccmixter.org/people/JeffSpeed68",
                "license_logo_url" => "http//ccmixter.org/ccskins/shared/images/lics/small-by-nc-3.png",
                "license_url" => "http//creativecommons.org/licenses/by-nc/3.0/",
                "license_name" => "Attribution Noncommercial  (3.0)",
                "upload_date_format" => "Thu, Dec 10, 2015 @ 10:45 AM",
                "files" => array(
                    array(
                        "file_format_info" => array(
                            "ps" => "12:51"
                        )
                    )
                ),
                "upload_description_plain" => "folk - rock christmas song"
            )
        );
            

        $expectedArray = array(
            0 => array(
                'author'    => 'Reiswerk',
                'title'     => 'Mirror (New Acapella Mix)',
                'duration'  => '03.14',
                'date'      => new \DateTime('2015-12-12 02:05:00'),
                'link'      => 'http//ccmixter.org/files/Reiswerk/52456',
                'license'   => 'by-nc',
                'service'   => 'ccmixter',
            ),
            1 => array(
                'author'    => 'JeffSpeed68',
                'title'     => 'Snowman',
                'duration'  => '12.51',
                'date'      => new \DateTime('2015-12-10 10:45:00'),
                'link'      => 'http//ccmixter.org/files/JeffSpeed68/52419',
                'license'   => 'by-nc',
                'service'   => 'ccmixter',
            ),
        );

        $apiClient = \Phake::mock('CCMusicSearchBundle\Service\ApiClient');
        \Phake::when($apiClient)->performRequest(\Phake::anyParameters())->thenReturn($rawSongArray);

        $SUT = new CCMixterApiService($apiClient, 'fake_uri', 'fake_key', 10, array('by'));
        $resultArray = $SUT->getSongRecords(array('tag' => 'fake_tag'));

        $this->assertEquals($expectedArray, $resultArray);
    }

    /**
     * @dataProvider durations
     */
    public function testItFormatsDuration($duration, $formattedDuration)
    {
        $apiClient = \Phake::mock('CCMusicSearchBundle\Service\ApiClient');
        $SUT = new CCMixterApiService($apiClient, 'fake_uri', 'fake_key', 10, array('by'));
        $this->assertEquals($formattedDuration, $SUT->formatDuration($duration));
    }

    public function durations()
    {
        return array(
            array('2:30', '02.30'),
            array('12:30', '12.30'),
            array('0:30', '00.30')
        );
    }

}
