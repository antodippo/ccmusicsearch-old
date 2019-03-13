<?php

namespace App\Model;

class Search
{
    /** @var string */
    private $searchString;

    public function getSearchString(): ?string
    {
        return $this->searchString;
    }

    public function setSearchString(string $searchString): void
    {
        $this->searchString = $searchString;
    }
}