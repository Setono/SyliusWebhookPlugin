<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Request;

use Symfony\Component\HttpFoundation\Request;

/**
 * Instead of using the \Psr\Http\Message\ServerRequestInterface which is not always serializable
 * we use this simplified class to represent a server request
 */
final class ServerRequest
{
    public string $method;

    public string $uri;

    public array $headers;

    public array $queryParams;

    public array $parsedBody;

    public array $attributes;

    public function __construct(
        string $method,
        string $uri,
        array $headers,
        array $queryParams,
        array $parsedBody,
        array $attributes
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->queryParams = $queryParams;
        $this->parsedBody = $parsedBody;
        $this->attributes = $attributes;
    }

    public static function createFromRequest(Request $request): self
    {
        $uri = $request->server->get('QUERY_STRING', '');
        $uri = $request->getSchemeAndHttpHost() . $request->getBaseUrl() . $request->getPathInfo() . ('' !== $uri ? '?' . $uri : '');

        return new self(
            $request->getMethod(),
            $uri,
            $request->headers->all(),
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all()
        );
    }
}
