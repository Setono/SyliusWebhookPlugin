<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Message\Handler;

use Setono\SyliusWebhookPlugin\Message\Event\IncomingWebhookReceived;
use Setono\SyliusWebhookPlugin\Model\IncomingWebhookInterface;
use Setono\SyliusWebhookPlugin\Processor\IncomingWebhookProcessorInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

final class IncomingWebhookReceivedHandler implements MessageHandlerInterface
{
    private RepositoryInterface $incomingWebhookRepository;

    private IncomingWebhookProcessorInterface $incomingWebhookProcessor;

    public function __construct(
        RepositoryInterface $incomingWebhookRepository,
        IncomingWebhookProcessorInterface $incomingWebhookProcessor
    ) {
        $this->incomingWebhookRepository = $incomingWebhookRepository;
        $this->incomingWebhookProcessor = $incomingWebhookProcessor;
    }

    public function __invoke(IncomingWebhookReceived $message): void
    {
        /** @var IncomingWebhookInterface|mixed|null $incomingWebhook */
        $incomingWebhook = $this->incomingWebhookRepository->find($message->getIncomingWebhookId());
        Assert::nullOrIsInstanceOf($incomingWebhook, IncomingWebhookInterface::class);

        if (null === $incomingWebhook) {
            return;
        }

        $this->incomingWebhookProcessor->process($incomingWebhook);
    }
}
