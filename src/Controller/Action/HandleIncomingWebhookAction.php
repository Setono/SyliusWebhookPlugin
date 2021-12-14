<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Controller\Action;

use Doctrine\Persistence\ManagerRegistry;
use Psr\EventDispatcher\EventDispatcherInterface;
use Setono\DoctrineObjectManagerTrait\ORM\ORMManagerTrait;
use Setono\SyliusWebhookPlugin\Event\PrePersistIncomingWebhookEvent;
use Setono\SyliusWebhookPlugin\Factory\IncomingWebhookFactoryInterface;
use Setono\SyliusWebhookPlugin\Message\Event\IncomingWebhookReceived;
use Setono\SyliusWebhookPlugin\Repository\EndpointRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;

final class HandleIncomingWebhookAction
{
    use ORMManagerTrait;

    private EndpointRepositoryInterface $endpointRepository;

    private IncomingWebhookFactoryInterface $incomingWebhookFactory;

    private MessageBusInterface $eventBus;

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        EndpointRepositoryInterface $endpointRepository,
        IncomingWebhookFactoryInterface $incomingWebhookFactory,
        MessageBusInterface $eventBus,
        ManagerRegistry $managerRegistry,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->endpointRepository = $endpointRepository;
        $this->incomingWebhookFactory = $incomingWebhookFactory;
        $this->eventBus = $eventBus;
        $this->managerRegistry = $managerRegistry;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(Request $request, string $code): Response
    {
        $endpoint = $this->endpointRepository->findOneByCode($code);
        if (null === $endpoint) {
            throw new NotFoundHttpException(sprintf('The endpoint with code "%s" does not exist', $code));
        }

        $token = $request->query->get('token');
        if (!is_string($token) || $endpoint->getToken() !== $token) {
            throw new NotFoundHttpException('Wrong token supplied');
        }

        $incomingWebhook = $this->incomingWebhookFactory->createFromRequest($request);
        $incomingWebhook->setEndpoint($endpoint);
        $this->eventDispatcher->dispatch(new PrePersistIncomingWebhookEvent($incomingWebhook));

        $manager = $this->getManager($incomingWebhook);
        $manager->persist($incomingWebhook);
        $manager->flush();

        $this->eventBus->dispatch(new IncomingWebhookReceived($incomingWebhook));

        return new Response();
    }
}
