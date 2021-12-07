<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Factory;

use Nyholm\Psr7\Factory\Psr17Factory;
use Setono\SyliusWebhookPlugin\Model\WebhookInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;

final class WebhookFactory implements WebhookFactoryInterface
{
    private FactoryInterface $decorated;

    public function __construct(FactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function createNew(): WebhookInterface
    {
        /** @var WebhookInterface $obj */
        $obj = $this->decorated->createNew();

        return $obj;
    }

    public function createFromRequest(Request $request): WebhookInterface
    {
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

        $obj = $this->createNew();
        $obj->setRequest($psrHttpFactory->createRequest($request));

        return $obj;
    }
}
