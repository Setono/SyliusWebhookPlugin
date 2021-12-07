<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Event;

use Setono\SyliusWebhookPlugin\Model\WebhookInterface;

final class PrePersistWebhookEvent
{
    public WebhookInterface $webhook;

    public function __construct(WebhookInterface $webhook)
    {
        $this->webhook = $webhook;
    }
}
