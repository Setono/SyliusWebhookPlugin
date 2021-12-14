<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Request;

use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

final class IncomingWebhookRequest
{
    public string $code;

    public ?string $content;

    public ParameterBag $query;

    public ParameterBag $request;

    public HeaderBag $headers;

    public ParameterBag $attributes;

    public function __construct(
        string $code,
        ?string $content,
        ParameterBag $query,
        ParameterBag $request,
        HeaderBag $headers,
        ParameterBag $attributes
    ) {
        $this->code = $code;
        $this->content = $content;
        $this->query = $query;
        $this->request = $request;
        $this->headers = $headers;
        $this->attributes = $attributes;
    }

    public static function createFromRequest(Request $request): self
    {
        $code = $request->attributes->get('code');
        Assert::string($code);

        $content = $request->getContent();

        /** @psalm-suppress DocblockTypeContradiction */
        if (!is_string($content)) {
            $content = null;
        }

        /** @psalm-suppress MixedArgumentTypeCoercion,InvalidArgument */
        return new self($code, $content, $request->query, $request->request, $request->headers, $request->attributes);
    }
}
