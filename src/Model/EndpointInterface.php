<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Model;

use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface EndpointInterface extends ResourceInterface, CodeAwareInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getToken(): string;

    public function setToken(string $token): void;
}
