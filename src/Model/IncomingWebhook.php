<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Model;

use DateTimeImmutable;
use DateTimeInterface;
use Setono\SyliusWebhookPlugin\Request\IncomingWebhookRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

class IncomingWebhook implements IncomingWebhookInterface
{
    protected string $id;

    protected string $state = self::STATE_PENDING;

    protected ?IncomingWebhookRequest $request = null;

    protected ?string $error = null;

    protected DateTimeInterface $receivedAt;

    public function __construct()
    {
        $this->id = (string) Uuid::v4();
        $this->receivedAt = new DateTimeImmutable();
    }

    public static function getStates(): array
    {
        return [
            self::STATE_PENDING, self::STATE_HANDLED, self::STATE_FAILED,
        ];
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

    public function getRequest(): ?IncomingWebhookRequest
    {
        return $this->request;
    }

    public function setRequest($request): void
    {
        if ($request instanceof Request) {
            $request = IncomingWebhookRequest::createFromRequest($request);
        }

        Assert::isInstanceOf($request, IncomingWebhookRequest::class);

        $this->request = $request;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function setError(?string $error): void
    {
        $this->error = $error;
    }

    public function getReceivedAt(): DateTimeInterface
    {
        return $this->receivedAt;
    }
}
