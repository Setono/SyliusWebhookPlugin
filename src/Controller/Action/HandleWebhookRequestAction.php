<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Controller\Action;

use Doctrine\Persistence\ManagerRegistry;
use Psr\EventDispatcher\EventDispatcherInterface;
use Setono\DoctrineObjectManagerTrait\ORM\ORMManagerTrait;
use Setono\SyliusWebhookPlugin\Event\PrePersistWebhookEvent;
use Setono\SyliusWebhookPlugin\Factory\WebhookFactoryInterface;
use Setono\SyliusWebhookPlugin\Message\Event\WebhookReceived;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class HandleWebhookRequestAction
{
    use ORMManagerTrait;

    private WebhookFactoryInterface $webhookFactory;

    private MessageBusInterface $eventBus;

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        WebhookFactoryInterface $webhookFactory,
        MessageBusInterface $eventBus,
        ManagerRegistry $managerRegistry,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->webhookFactory = $webhookFactory;
        $this->eventBus = $eventBus;
        $this->managerRegistry = $managerRegistry;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(Request $request): Response
    {
        $webhook = $this->webhookFactory->createFromRequest($request);
        $this->eventDispatcher->dispatch(new PrePersistWebhookEvent($webhook));

        $manager = $this->getManager($webhook);
        $manager->persist($webhook);
        $manager->flush();

        $this->eventBus->dispatch(new WebhookReceived($webhook));

        return new Response();
    }
}
