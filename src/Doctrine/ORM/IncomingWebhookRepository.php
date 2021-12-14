<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Doctrine\ORM;

use DateTimeInterface;
use Setono\SyliusWebhookPlugin\Repository\IncomingWebhookRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class IncomingWebhookRepository extends EntityRepository implements IncomingWebhookRepositoryInterface
{
    public function prune(DateTimeInterface $olderThan): void
    {
        $this->createQueryBuilder('o')
            ->delete()
            ->andWhere('o.receivedAt < :olderThan')
            ->setParameter('olderThan', $olderThan)
            ->getQuery()
            ->execute()
        ;
    }
}
