<?php

namespace App\Model;

class SongRecord
{

    /** @var string */
    public $author;

    /** @var string */
    public $title;

    /** @var string */
    public $duration;

    /** @var \DateTime */
    public $date;

    /** @var string */
    public $link;

    /** @var string|null */
    public $license;

    /** @var string */
    public $service;

    function __construct(
        string $author,
        string $title,
        string $duration,
        \DateTime $date,
        string $link,
        ?string $license,
        string $service
    ) {
        $this->author = $author;
        $this->title = $title;
        $this->duration = $duration;
        $this->date = $date;
        $this->link = $link;
        $this->license = $license;
        $this->service = $service;
    }
}