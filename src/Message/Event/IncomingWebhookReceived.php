<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Message\Event;

use Setono\SyliusWebhookPlugin\Model\IncomingWebhookInterface;
use Webmozart\Assert\Assert;

final class IncomingWebhookReceived implements EventInterface
{
    private string $incomingWebhookId;

    /**
     * @param string|IncomingWebhookInterface $incomingWebhookId
     */
    public function __construct($incomingWebhookId)
    {
        if ($incomingWebhookId instanceof IncomingWebhookInterface) {
            $incomingWebhookId = $incomingWebhookId->getId();
        }

        Assert::string($incomingWebhookId);

        $this->incomingWebhookId = $incomingWebhookId;
    }

    public function getIncomingWebhookId(): string
    {
        return $this->incomingWebhookId;
    }
}
