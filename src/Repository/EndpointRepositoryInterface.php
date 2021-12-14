<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Repository;

use Setono\SyliusWebhookPlugin\Model\EndpointInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface EndpointRepositoryInterface extends RepositoryInterface
{
    public function findOneBySlug(string $slug): ?EndpointInterface;
}
