<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Processor;

use Setono\SyliusWebhookPlugin\Model\IncomingWebhookInterface;

interface IncomingWebhookProcessorInterface
{
    public function process(IncomingWebhookInterface $incomingWebhook): void;

    /**
     * Returns true if the processor supports the given webhook
     */
    public function supports(IncomingWebhookInterface $incomingWebhook): bool;
}
