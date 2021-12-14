<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Model;

use DateTimeImmutable;
use DateTimeInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

class IncomingWebhook implements IncomingWebhookInterface
{
    protected string $id;

    protected string $state = self::STATE_PENDING;

    protected ?ServerRequestInterface $request = null;

    protected ?string $error = null;

    protected DateTimeInterface $receivedAt;

    protected ?EndpointInterface $endpoint = null;

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

    public function getRequest(): ?ServerRequestInterface
    {
        return $this->request;
    }

    public function setRequest(ServerRequestInterface $request): void
    {
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

    public function getEndpoint(): ?EndpointInterface
    {
        return $this->endpoint;
    }

    public function setEndpoint(?EndpointInterface $endpoint): void
    {
        $this->endpoint = $endpoint;
    }
}
