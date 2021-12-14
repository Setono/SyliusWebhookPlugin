<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Model;

use Symfony\Component\Uid\Uuid;

class Endpoint implements EndpointInterface
{
    protected ?int $id = null;

    protected ?string $name = null;

    protected ?string $slug = null;

    protected string $token;

    public function __construct()
    {
        $this->token = (string) Uuid::v4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }
}
