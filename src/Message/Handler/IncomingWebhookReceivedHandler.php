<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Message\Handler;

use Setono\SyliusWebhookPlugin\Message\Event\IncomingWebhookReceived;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class IncomingWebhookReceivedHandler implements MessageHandlerInterface
{
    private RepositoryInterface $incomingWebhookRepository;

    public function __construct(RepositoryInterface $incomingWebhookRepository)
    {
        $this->incomingWebhookRepository = $incomingWebhookRepository;
    }

    public function __invoke(IncomingWebhookReceived $message): void
    {
        $incomingWebhook = $this->incomingWebhookRepository->find($message->getIncomingWebhookId());
    }
}
