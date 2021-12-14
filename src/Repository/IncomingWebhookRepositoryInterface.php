<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Repository;

use DateTimeInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface IncomingWebhookRepositoryInterface extends RepositoryInterface
{
    /**
     * This will remove incoming webhooks from the table that was received before $olderThan
     */
    public function prune(DateTimeInterface $olderThan): void;
}
