<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Model;

use DateTimeInterface;
use Setono\SyliusWebhookPlugin\Request\ServerRequest;
use Sylius\Component\Resource\Model\ResourceInterface;

interface IncomingWebhookInterface extends ResourceInterface
{
    public const STATE_PENDING = 'pending';

    public const STATE_HANDLED = 'handled';

    public const STATE_FAILED = 'failed';

    public function getId(): string;

    public function getState(): string;

    public function setState(string $state): void;

    public function getRequest(): ?ServerRequest;

    public function setRequest(ServerRequest $request): void;

    public function getError(): ?string;

    public function setError(?string $error): void;

    public function getReceivedAt(): DateTimeInterface;

    public function getEndpoint(): ?EndpointInterface;

    public function setEndpoint(?EndpointInterface $endpoint): void;
}
