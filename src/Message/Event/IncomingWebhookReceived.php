<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Message\Event;

use Setono\SyliusWebhookPlugin\Model\IncomingWebhookInterface;
use Webmozart\Assert\Assert;

final class IncomingWebhookReceived implements EventInterface
{
    private string $incomingWebhookId;

    /**
     * @param mixed|string|IncomingWebhookInterface $incomingWebhook
     */
    public function __construct($incomingWebhook)
    {
        if ($incomingWebhook instanceof IncomingWebhookInterface) {
            $incomingWebhook = $incomingWebhook->getId();
        }

        Assert::string($incomingWebhook);

        $this->incomingWebhookId = $incomingWebhook;
    }

    public function getIncomingWebhookId(): string
    {
        return $this->incomingWebhookId;
    }
}
