<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusWebhookPlugin\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\SyliusWebhookPlugin\DependencyInjection\SetonoSyliusWebhookExtension;

/**
 * See examples of tests and configuration options here: https://github.com/SymfonyTest/SymfonyDependencyInjectionTest
 */
final class SetonoSyliusWebhookExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new SetonoSyliusWebhookExtension(),
        ];
    }
}
