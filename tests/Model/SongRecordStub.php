<?php

declare(strict_types=1);

namespace App\Tests\Model;

use App\Model\SongRecord;

class SongRecordStub
{
    public static function fromTitle(string $title): SongRecord
    {
        return new SongRecord(
            'The Beatles',
            $title,
            '02.40',
            '120',
            'brit pop beat guitar bass drums',
            new \DateTime('2020-05-02 00:00:00'),
            'https://www.jamendo.com/track/666',
            'by-sa',
            'jamendo'
        );
    }
}