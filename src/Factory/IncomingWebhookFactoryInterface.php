<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Factory;

use Setono\SyliusWebhookPlugin\Model\IncomingWebhookInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

interface IncomingWebhookFactoryInterface extends FactoryInterface
{
    public function createNew(): IncomingWebhookInterface;

    public function createFromRequest(Request $request): IncomingWebhookInterface;
}
