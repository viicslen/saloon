<?php

declare(strict_types=1);

namespace Saloon\Traits\RequestProperties;

use Saloon\Http\Request;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Exceptions\Request\FatalRequestException;

trait HasTries
{
    /**
     * The number of times a request should be retried if a failure response is returned.
     *
     * Set to null to disable the retry functionality.
     */
    public ?int $tries = null;

    /**
     * The interval in milliseconds Saloon should wait between retries.
     *
     * For example 500ms = 0.5 seconds.
     *
     * Set to null to disable the retry interval.
     */
    public ?int $retryInterval = null;

    /**
     * Should Saloon use exponential backoff during retries?
     *
     * When true, Saloon will double the retry interval after each attempt.
     */
    public ?bool $useExponentialBackoff = null;

    /**
     * Should Saloon throw an exception after exhausting the maximum number of retries?
     *
     * When false, Saloon will return the last response attempted.
     *
     * Set to null to always throw after maximum retry attempts.
     */
    public ?bool $throwOnMaxTries = null;

    /**
     * Define whether the request should be retried.
     *
     * You can access the response from the RequestException. You can also modify the
     * request before the next attempt is made.
     */
    public function handleRetry(FatalRequestException|RequestException $exception, Request $request): bool
    {
        return true;
    }

    public function withRetryInterval(?int $milliseconds): static
    {
        $this->retryInterval = $milliseconds;

        return $this;
    }
    
    public function withExponentialBackoff(?bool $exponentialBackoff): static
    {
        $this->useExponentialBackoff = $exponentialBackoff;

        return $this;
    }

    public function throwOnMaxTries(?bool $throwOnMaxTries): static
    {
        $this->throwOnMaxTries = $throwOnMaxTries;

        return $this;
    }

    public function withRetry(?int $tries, ?int $intervalMilliseconds = null, ?bool $exponentialBackoff = null, ?bool $throwOnMaxTries = null): static
    {
        $this->tries = $tries;

        if ($intervalMilliseconds) {
            $this->withRetryInterval($intervalMilliseconds);
        }

        if ($exponentialBackoff) {
            $this->withExponentialBackoff($exponentialBackoff);
        }

        if ($throwOnMaxTries) {
            $this->throwOnMaxTries($throwOnMaxTries);
        }

        return $this;
    }

    public function withoutRetry(): static
    {
        return $this->withRetry(null);
    }
}
