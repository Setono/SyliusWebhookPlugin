<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SetonoSyliusWebhookPlugin extends Bundle
{
    use SyliusPluginTrait;
}
