# Sylius Webhook Plugin

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]

Handle webhooks in your Sylius store

## Installation

### Step 1: Download the plugin

```bash
composer require setono/sylius-webhook-plugin
```

### Step 2: Enable the plugin

Then, enable the plugin by adding the following to the list of registered plugins/bundles
in the `config/bundles.php` file of your project:

```php
<?php

return [
    // ...
    
    Setono\SyliusWebhookPlugin\SetonoSyliusWebhookPlugin::class => ['all' => true],
    
    // It is important to add plugin before the grid bundle
    Sylius\Bundle\GridBundle\SyliusGridBundle::class => ['all' => true],
        
    // ...
];
```

**NOTE** that you must instantiate the plugin before the grid bundle, else you will see an exception like
`You have requested a non-existent parameter "setono_sylius_webhook.model.endpoint.class".`

### Step 3: Import routing

```yaml
# config/routes/setono_sylius_webhook.yaml
setono_sylius_webhook:
    resource: "@SetonoSyliusWebhookPlugin/Resources/config/routes.yaml"
```

If you don't use localized URLs, use this routing file instead: `@SetonoSyliusWebhookPlugin/Resources/config/routes_no_locale.yaml`

### Step 4: Configure plugin

```yaml
# config/packages/setono_sylius_webhook.yaml
imports:
    - { resource: "@SetonoSyliusWebhookPlugin/Resources/config/app/config.yaml" }
```

### Step 5: Update database schema

Use Doctrine migrations to create a migration file and update the database.

```bash
$ bin/console doctrine:migrations:diff
$ bin/console doctrine:migrations:migrate
```

### Step 6: Using asynchronous transport (optional, but recommended)

All events in this plugin will extend the [EventInterface](src/Message/Event/EventInterface.php).
Therefore, you can route all events easily by adding this to your [Messenger config](https://symfony.com/doc/current/messenger.html#routing-messages-to-a-transport):

```yaml
# config/packages/messenger.yaml
framework:
    messenger:
        routing:
            # Route all command messages to the async transport
            # This presumes that you have already set up an 'async' transport
            # See docs on how to setup a transport like that: https://symfony.com/doc/current/messenger.html#transports-async-queued-messages
            'Setono\SyliusWebhookPlugin\Message\Event\EventInterface': async
```

[ico-version]: https://poser.pugx.org/setono/sylius-webhook-plugin/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/sylius-webhook-plugin/v/unstable
[ico-license]: https://poser.pugx.org/setono/sylius-webhook-plugin/license
[ico-github-actions]: https://github.com/Setono/SyliusWebhookPlugin/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/Setono/SyliusWebhookPlugin/branch/master/graph/badge.svg

[link-packagist]: https://packagist.org/packages/setono/sylius-webhook-plugin
[link-github-actions]: https://github.com/Setono/SyliusWebhookPlugin/actions
[link-code-coverage]: https://codecov.io/gh/Setono/SyliusWebhookPlugin
