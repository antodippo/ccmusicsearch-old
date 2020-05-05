<?php

declare(strict_types=1);

namespace App\Tests\Model;

use GuzzleHttp\Promise\PromiseInterface;

class PromiseStub implements PromiseInterface
{
    public function then(callable $onFulfilled = null, callable $onRejected = null)
    {
        return $this;
    }

    public function otherwise(callable $onRejected)
    {
        return $this;
    }

    public function getState()
    {
        return '';
    }

    public function resolve($value)
    {
        return $this;
    }

    public function reject($reason)
    {
        return $this;
    }

    public function cancel()
    {
        return $this;
    }

    public function wait($unwrap = true)
    {
        return $this;
    }

    public function getBody(): self {
        return $this;
    }

    public function getContents(): string {
        return 'stub_string';
    }
}