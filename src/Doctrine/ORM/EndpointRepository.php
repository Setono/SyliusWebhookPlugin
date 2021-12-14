<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Doctrine\ORM;

use Setono\SyliusWebhookPlugin\Model\EndpointInterface;
use Setono\SyliusWebhookPlugin\Repository\EndpointRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Webmozart\Assert\Assert;

class EndpointRepository extends EntityRepository implements EndpointRepositoryInterface
{
    public function findOneBySlug(string $slug): ?EndpointInterface
    {
        $endpoint = $this->findOneBy([
            'slug' => $slug,
        ]);
        Assert::nullOrIsInstanceOf($endpoint, EndpointInterface::class);

        return $endpoint;
    }
}
