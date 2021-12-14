<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Factory;

use Nyholm\Psr7\Factory\Psr17Factory;
use Setono\SyliusWebhookPlugin\Model\IncomingWebhookInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
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
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        $psrRequest = $psrHttpFactory->createRequest($request);

        $obj = $this->createNew();
        $obj->setRequest($psrRequest);

        return $obj;
    }
}
