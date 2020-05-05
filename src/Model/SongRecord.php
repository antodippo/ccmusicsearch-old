<?php

declare(strict_types=1);

namespace App\Model;

class SongRecord
{
    public string $author;
    public string $title;
    public string $duration;
    public string $bmp;
    public \DateTime $date;
    public string $link;
    public string $license;
    public string $service;

    function __construct(
        string $author,
        string $title,
        string $duration,
        string $bpm,
        \DateTime $date,
        string $link,
        string $license,
        string $service
    ) {
        $this->author = $author;
        $this->title = $title;
        $this->duration = $duration;
        $this->bpm = $bpm;
        $this->date = $date;
        $this->link = $link;
        $this->license = $license;
        $this->service = $service;
    }
}