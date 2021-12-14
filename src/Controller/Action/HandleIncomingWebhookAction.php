<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Controller\Action;

use Doctrine\Persistence\ManagerRegistry;
use Psr\EventDispatcher\EventDispatcherInterface;
use Setono\DoctrineObjectManagerTrait\ORM\ORMManagerTrait;
use Setono\SyliusWebhookPlugin\Event\PrePersistIncomingWebhookEvent;
use Setono\SyliusWebhookPlugin\Factory\IncomingWebhookFactoryInterface;
use Setono\SyliusWebhookPlugin\Message\Event\IncomingWebhookReceived;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class HandleIncomingWebhookAction
{
    use ORMManagerTrait;

    private IncomingWebhookFactoryInterface $incomingWebhookFactory;

    private MessageBusInterface $eventBus;

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        IncomingWebhookFactoryInterface $incomingWebhookFactory,
        MessageBusInterface $eventBus,
        ManagerRegistry $managerRegistry,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->incomingWebhookFactory = $incomingWebhookFactory;
        $this->eventBus = $eventBus;
        $this->managerRegistry = $managerRegistry;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(Request $request): Response
    {
        $incomingWebhook = $this->incomingWebhookFactory->createFromRequest($request);
        $this->eventDispatcher->dispatch(new PrePersistIncomingWebhookEvent($incomingWebhook));

        $manager = $this->getManager($incomingWebhook);
        $manager->persist($incomingWebhook);
        $manager->flush();

        $this->eventBus->dispatch(new IncomingWebhookReceived($incomingWebhook));

        return new Response();
    }
}
