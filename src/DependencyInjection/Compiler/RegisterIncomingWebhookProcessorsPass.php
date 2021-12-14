<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterIncomingWebhookProcessorsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('setono_sylius_webhook.processor.composite_incoming_webhook')) {
            return;
        }

        $compositeProcessor = $container->getDefinition('setono_sylius_webhook.processor.composite_incoming_webhook');

        /** @var string $id */
        foreach (array_keys($container->findTaggedServiceIds('setono_sylius_webhook.incoming_webhook_processor')) as $id) {
            $compositeProcessor->addMethodCall('add', [new Reference($id)]);
        }
    }
}
