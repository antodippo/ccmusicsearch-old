<?php

declare(strict_types=1);

namespace App\Model;

class Search
{
    private string $searchString = '';

    public function getSearchString(): ?string
    {
        return $this->searchString;
    }

    public function setSearchString(string $searchString): void
    {
        $this->searchString = $searchString;
    }
}