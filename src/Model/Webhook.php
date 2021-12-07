<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Model;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

class Webhook implements WebhookInterface
{
    protected string $id;

    protected string $state = self::STATE_PENDING;

    protected ?ServerRequestInterface $request = null;

    public static function getStates(): array
    {
        return [
            self::STATE_PENDING, self::STATE_HANDLED, self::STATE_FAILED,
        ];
    }

    public function __construct()
    {
        $this->id = (string) Uuid::v4();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        Assert::oneOf($state, self::getStates());

        $this->state = $state;
    }

    public function getRequest(): ?ServerRequestInterface
    {
        return $this->request;
    }

    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }
}
