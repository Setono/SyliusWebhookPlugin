<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Factory;

use Setono\SyliusWebhookPlugin\Model\IncomingWebhookInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class IncomingWebhookFactory implements IncomingWebhookFactoryInterface
{
    private FactoryInterface $decorated;

    public function __construct(FactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function createNew(): IncomingWebhookInterface
    {
        /** @var IncomingWebhookInterface $obj */
        $obj = $this->decorated->createNew();

        return $obj;
    }

    public function createFromRequest(Request $request): IncomingWebhookInterface
    {
        $obj = $this->createNew();
        $obj->setRequest($request);

        return $obj;
    }
}
