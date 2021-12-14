<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuBuilder
{
    public function addSection(MenuBuilderEvent $event): void
    {
        $header = $this->getHeader($event->getMenu());

        $header
            ->addChild('incoming_webhooks', [
                'route' => 'setono_sylius_webhook_admin_incoming_webhook_index',
            ])
            ->setLabel('setono_sylius_webhook.menu.admin.main.webhooks.incoming_webhooks')
            ->setLabelAttribute('icon', 'recycle')
        ;

        $header
            ->addChild('endpoints', [
                'route' => 'setono_sylius_webhook_admin_endpoint_index',
            ])
            ->setLabel('setono_sylius_webhook.menu.admin.main.webhooks.endpoints')
            ->setLabelAttribute('icon', 'linkify')
        ;
    }

    private function getHeader(ItemInterface $menu): ItemInterface
    {
        $header = $menu->getChild('webhooks');

        return $header ?? $menu->addChild('webhooks')
            ->setLabel('setono_sylius_webhook.menu.admin.main.webhooks.header')
        ;
    }
}
