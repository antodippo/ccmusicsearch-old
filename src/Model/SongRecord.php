<?php

namespace App\Model;

class SongRecord
{
    public $author;
    public $title;
    public $duration;
    public $date;
    public $link;
    public $license;
    public $service;

    function __construct($author, $title, $duration, $date, $link, $license, $service)
    {
        $this->author = $author;
        $this->title = $title;
        $this->duration = $duration;
        $this->date = $date;
        $this->link = $link;
        $this->license = $license;
        $this->service = $service;
    }

}