<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Message\Event;

final class IncomingWebhookReceived implements EventInterface
{
    private string $incomingWebhookId;

    public function __construct(string $incomingWebhookId)
    {
        $this->incomingWebhookId = $incomingWebhookId;
    }

    public function getIncomingWebhookId(): string
    {
        return $this->incomingWebhookId;
    }
}
