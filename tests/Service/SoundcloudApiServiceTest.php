<?php

namespace App\Tests\Service;

use App\Model\SongRecord;
use App\Service\SoundcloudApiService;
use PHPUnit\Framework\TestCase;

class SoundcloudApiServiceTest extends TestCase
{
    public function testItGetSongRecords()
    {
        $rawSongArray = array(
            0 => array (
                'download_url' => NULL,
                'key_signature' => '',
                'user_favorite' => false,
                'likes_count' => 291612,
                'release' => '',
                'attachments_uri' => 'https://api.soundcloud.com/tracks/114419538/attachments',
                'waveform_url' => 'https://w1.sndcdn.com/efdrjZctZysl_m.png',
                'purchase_url' => 'https://www.hive.co/l/27m8',
                'video_url' => NULL,
                'streamable' => true,
                'artwork_url' => 'https://i1.sndcdn.com/artworks-000059639237-djo455-large.jpg',
                'comment_count' => 21790,
                'commentable' => true,
                'description' => 'sadasdasdasd',
                'download_count' => 694306,
                'downloadable' => false,
                'embeddable_by' => 'all',
                'favoritings_count' => 291612,
                'genre' => 'SINEAD ',
                'isrc' => '',
                'label_id' => NULL,
                'label_name' => '',
                'license' => 'cc-by',
                'original_content_size' => 10667404,
                'original_format' => 'mp3',
                'playback_count' => 18199988,
                'purchase_title' => NULL,
                'release_day' => NULL,
                'release_month' => NULL,
                'release_year' => NULL,
                'reposts_count' => 114148,
                'state' => 'finished',
                'tag_list' => '',
                'track_type' => 'remix',
                'user' =>
                    array (
                        'avatar_url' => 'https://i1.sndcdn.com/avatars-000157362167-q7jatm-large.jpg',
                        'id' => 46182209,
                        'kind' => 'user',
                        'permalink_url' => 'http://soundcloud.com/eatdatcake',
                        'uri' => 'https://api.soundcloud.com/users/46182209',
                        'username' => 'CAKED UP',
                        'permalink' => 'eatdatcake',
                        'last_modified' => '2015/10/06 21:32:55 +0000',
                    ),
                'bpm' => NULL,
                'user_playback_count' => NULL,
                'id' => 114419538,
                'kind' => 'track',
                'created_at' => '2013/10/08 18:08:00 +0000',
                'last_modified' => '2015/11/20 00:45:35 +0000',
                'permalink' => 'wrecking-ball-caked-up-remix',
                'permalink_url' => 'https://soundcloud.com/eatdatcake/wrecking-ball-caked-up-remix',
                'title' => 'WRECKING BALL (CAKED UP REMIX) FREE DOWNLOAD',
                'duration' => 262841,
                'sharing' => 'public',
                'stream_url' => 'https://api.soundcloud.com/tracks/114419538/stream',
                'uri' => 'https://api.soundcloud.com/tracks/114419538',
                'user_id' => 46182209,
            ),
            1 => array (
                'download_url' => NULL,
                'key_signature' => '',
                'user_favorite' => false,
                'likes_count' => 118830,
                'release' => '',
                'attachments_uri' => 'https://api.soundcloud.com/tracks/112987097/attachments',
                'waveform_url' => 'https://w1.sndcdn.com/I5poXecJTSll_m.png',
                'purchase_url' => 'https://www.hive.co/l/27kr',
                'video_url' => NULL,
                'streamable' => true,
                'artwork_url' => 'https://i1.sndcdn.com/artworks-000058880412-u4r5lr-large.jpg',
                'comment_count' => 8238,
                'commentable' => true,
                'description' => 'sadasdasdasda',
                'download_count' => 402963,
                'downloadable' => false,
                'embeddable_by' => 'all',
                'favoritings_count' => 118830,
                'genre' => 'jon stark ',
                'isrc' => '',
                'label_id' => NULL,
                'label_name' => '',
                'license' => 'cc-by',
                'original_content_size' => 9070418,
                'original_format' => 'mp3',
                'playback_count' => 7973353,
                'purchase_title' => NULL,
                'release_day' => NULL,
                'release_month' => NULL,
                'release_year' => NULL,
                'reposts_count' => 49360,
                'state' => 'finished',
                'tag_list' => '',
                'track_type' => 'remix',
                'user' =>
                    array (
                        'avatar_url' => 'https://i1.sndcdn.com/avatars-000157362167-q7jatm-large.jpg',
                        'id' => 46182209,
                        'kind' => 'user',
                        'permalink_url' => 'http://soundcloud.com/eatdatcake',
                        'uri' => 'https://api.soundcloud.com/users/46182209',
                        'username' => 'CAKED UP',
                        'permalink' => 'eatdatcake',
                        'last_modified' => '2015/10/06 21:32:55 +0000',
                    ),
                'bpm' => NULL,
                'user_playback_count' => NULL,
                'id' => 112987097,
                'kind' => 'track',
                'created_at' => '2013/09/29 01:22:28 +0000',
                'last_modified' => '2015/11/14 15:52:39 +0000',
                'permalink' => 'royals-caked-up-remix',
                'permalink_url' => 'https://soundcloud.com/eatdatcake/royals-caked-up-remix',
                'title' => 'ROYALS-(CAKED UP REMIX) **FREE DOWNLOAD**',
                'duration' => 220911,
                'sharing' => 'public',
                'stream_url' => 'https://api.soundcloud.com/tracks/112987097/stream',
                'uri' => 'https://api.soundcloud.com/tracks/112987097',
                'user_id' => 46182209,
            ),
        );

        $expectedArray = array(
            0 => new SongRecord(
                'CAKED UP',
                'WRECKING BALL (CAKED UP REMIX) FREE DOWNLOAD',
                '04.22',
                new \DateTime('2013-10-08 18:08:00 +0000'),
                'https://soundcloud.com/eatdatcake/wrecking-ball-caked-up-remix',
                'cc-by',
                'soundcloud'
            ),
            1 => new SongRecord(
                'CAKED UP',
                'ROYALS-(CAKED UP REMIX) **FREE DOWNLOAD**',
                '03.40',
                new \DateTime('2013-09-29 01:22:28 +0000'),
                'https://soundcloud.com/eatdatcake/royals-caked-up-remix',
                'cc-by',
                'soundcloud'
            ),
        );

        $apiClient = \Phake::mock('App\Service\GuzzleApiClient');
        \Phake::when($apiClient)->performRequest(\Phake::anyParameters())->thenReturn($rawSongArray);

        $SUT = new SoundcloudApiService($apiClient, 'fake_uri', 'fake_key', 10, array('by'));
        $resultArray = $SUT->getSongRecords(array('tag' => 'fake_tag'));

        $this->assertEquals($expectedArray, $resultArray);
    }
}
