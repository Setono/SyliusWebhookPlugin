<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin;

use Setono\SyliusWebhookPlugin\DependencyInjection\Compiler\RegisterIncomingWebhookProcessorsPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SetonoSyliusWebhookPlugin extends AbstractResourceBundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterIncomingWebhookProcessorsPass());
    }

    public function getSupportedDrivers(): array
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }
}
