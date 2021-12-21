<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Request;

use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

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

    public ?string $body;

    public array $parsedBody;

    public array $attributes;

    public function __construct(
        string $method,
        string $uri,
        array $headers,
        array $queryParams,
        ?string $body,
        array $parsedBody,
        array $attributes
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->queryParams = $queryParams;
        $this->body = $body;
        $this->parsedBody = $parsedBody;
        $this->attributes = $attributes;
    }

    public function __toString(): string
    {
        return print_r($this, true);
    }

    /**
     * This method is more or less copied from here: https://github.com/symfony/psr-http-message-bridge/blob/main/Factory/PsrHttpFactory.php
     */
    public static function createFromRequest(Request $request): self
    {
        $uri = $request->server->get('QUERY_STRING', '');
        Assert::string($uri);

        $uri = $request->getSchemeAndHttpHost() . $request->getBaseUrl() . $request->getPathInfo() . ('' !== $uri ? '?' . $uri : '');

        $body = $request->getContent();

        /** @psalm-suppress DocblockTypeContradiction */
        if (!is_string($body) || '' === $body) {
            $body = null;
        }

        return new self(
            $request->getMethod(),
            $uri,
            $request->headers->all(),
            $request->query->all(),
            $body,
            $request->request->all(),
            $request->attributes->all()
        );
    }
}
