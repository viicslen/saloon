<?php

declare(strict_types=1);

namespace Saloon\Tests\Fixtures\Requests;

use Saloon\Contracts\Body\WithBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

class HasBodyRequest extends Request  implements WithBody
{
    use HasBody;

    /**
     * Define the method that the request will use.
     *
     * @var Method
     */
    protected Method $method = Method::GET;

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/user';
    }

    protected function defaultBody(): ?string
    {
        return 'name: Sam';
    }
}
