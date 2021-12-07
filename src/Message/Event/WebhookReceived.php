<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Message\Event;

use Setono\SyliusWebhookPlugin\Model\WebhookInterface;
use Webmozart\Assert\Assert;

final class WebhookReceived implements EventInterface
{
    private string $webhookId;

    /**
     * @param mixed|string|WebhookInterface $webhook
     */
    public function __construct($webhook)
    {
        if ($webhook instanceof WebhookInterface) {
            $webhook = $webhook->getId();
        }

        Assert::string($webhook);

        $this->webhookId = $webhook;
    }

    public function getWebhookId(): string
    {
        return $this->webhookId;
    }
}
