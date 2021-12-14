<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Processor;

use Doctrine\Persistence\ManagerRegistry;
use Setono\DoctrineObjectManagerTrait\ORM\ORMManagerTrait;
use Setono\SyliusWebhookPlugin\Model\IncomingWebhookInterface;

final class CompositeIncomingWebhookProcessor implements IncomingWebhookProcessorInterface
{
    use ORMManagerTrait;

    /** @var array<array-key, IncomingWebhookProcessorInterface> */
    private array $processors = [];

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function process(IncomingWebhookInterface $incomingWebhook): void
    {
        $manager = $this->getManager($incomingWebhook);

        foreach ($this->processors as $processor) {
            if ($processor->supports($incomingWebhook)) {
                $processor->process($incomingWebhook);

                $manager->flush();

                return;
            }
        }

        $incomingWebhook->setState(IncomingWebhookInterface::STATE_FAILED);
        $incomingWebhook->setError('No processor supports the given webhook');
        $manager->flush();
    }

    public function supports(IncomingWebhookInterface $incomingWebhook): bool
    {
        foreach ($this->processors as $processor) {
            if ($processor->supports($incomingWebhook)) {
                return true;
            }
        }

        return false;
    }

    public function add(IncomingWebhookProcessorInterface $incomingWebhookProcessor): void
    {
        $this->processors[] = $incomingWebhookProcessor;
    }
}
