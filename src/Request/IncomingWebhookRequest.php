<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Request;

use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

final class IncomingWebhookRequest
{
    public string $slug;

    public ?string $content;

    public InputBag $query;

    public InputBag $request;

    public HeaderBag $headers;

    public ParameterBag $attributes;

    public function __construct(string $slug, ?string $content, InputBag $query, InputBag $request, HeaderBag $headers, ParameterBag $attributes)
    {
        $this->slug = $slug;
        $this->content = $content;
        $this->query = $query;
        $this->request = $request;
        $this->headers = $headers;
        $this->attributes = $attributes;
    }

    public static function createFromRequest(Request $request): self
    {
        $slug = $request->attributes->get('slug');
        Assert::string($slug);

        $content = $request->getContent();
        if (!is_string($content)) {
            $content = null;
        }

        return new self($slug, $content, $request->query, $request->request, $request->headers, $request->attributes);
    }
}
