<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Factory;

use Setono\SyliusWebhookPlugin\Model\WebhookInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

interface WebhookFactoryInterface extends FactoryInterface
{
    public function createNew(): WebhookInterface;

    public function createFromRequest(Request $request): WebhookInterface;
}
