<?php

declare(strict_types=1);

namespace Saloon\Http;

use Saloon\Traits\Bootable;
use Saloon\Traits\Makeable;
use Saloon\Contracts\Request;
use Saloon\Traits\Conditionable;
use Saloon\Traits\HasMockClient;
use Saloon\Traits\Connector\HasPool;
use Saloon\Traits\Connector\HasSender;
use Saloon\Traits\Connector\SendsRequests;
use Saloon\Traits\Connector\ProxiesRequests;
use Saloon\Traits\Auth\AuthenticatesRequests;
use Saloon\Traits\Request\CastDtoFromResponse;
use Saloon\Traits\Responses\HasCustomResponses;
use Saloon\Contracts\Connector as ConnectorContract;
use Saloon\Traits\RequestProperties\HasRequestProperties;

abstract class Connector implements ConnectorContract
{
    use AuthenticatesRequests;
    use HasRequestProperties;
    use CastDtoFromResponse;
    use HasCustomResponses;
    use ProxiesRequests;
    use HasMockClient;
    use SendsRequests;
    use Conditionable;
    use HasSender;
    use Bootable;
    use Makeable;
    use HasPool;

    /**
     * Prepare a new request
     *
     * @param \Saloon\Contracts\Request $request
     * @return \Saloon\Contracts\Request
     */
    public function request(Request $request): Request
    {
        return $request->setConnector($this);
    }

    /**
     * Dynamically proxy other methods to try and call a requests.
     *
     * @param $method
     * @param $arguments
     * @return mixed
     * @throws \ReflectionException
     * @throws \Saloon\Exceptions\ClassNotFoundException
     * @throws \Saloon\Exceptions\ConnectorMethodNotFoundException
     * @throws \Saloon\Exceptions\InvalidRequestException
     */
    public function __call($method, $arguments)
    {
        return $this->proxyRequest($method, $arguments);
    }

    /**
     * Dynamically proxy other methods to try and call a requests.
     *
     * @param $method
     * @param $arguments
     * @return mixed
     * @throws \ReflectionException
     * @throws \Saloon\Exceptions\ClassNotFoundException
     * @throws \Saloon\Exceptions\ConnectorMethodNotFoundException
     * @throws \Saloon\Exceptions\InvalidRequestException
     */
    public static function __callStatic($method, $arguments)
    {
        return (new static)->proxyRequest($method, $arguments);
    }
}