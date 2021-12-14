<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Event;

use Setono\SyliusWebhookPlugin\Model\IncomingWebhookInterface;

final class PrePersistIncomingWebhookEvent
{
    public IncomingWebhookInterface $incomingWebhook;

    public function __construct(IncomingWebhookInterface $incomingWebhook)
    {
        $this->incomingWebhook = $incomingWebhook;
    }
}
