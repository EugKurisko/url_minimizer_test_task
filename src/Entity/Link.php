<?php
namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LinkRepository::class)]
#[ORM\Table(name: "links")]
class Link
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 1024)]
    private string $originalUrl;

    #[ORM\Column(type: "string", length: 50, unique: true)]
    private string $shortCode;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $expiresAt = null;

    #[ORM\Column(type: "integer")]
    private int $clicks = 0;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $createdAt;

    public function __construct(string $originalUrl, string $shortCode, ?\DateTimeInterface $expiresAt = null)
    {
        $this->originalUrl = $originalUrl;
        $this->shortCode   = $shortCode;
        $this->expiresAt   = $expiresAt;
        $this->createdAt   = new \DateTimeImmutable();
    }

    public function isExpired(): bool
    {
        return $this->expiresAt !== null && $this->expiresAt < new \DateTimeImmutable();
    }

    public function incrementClicks(): void
    {
        $this->clicks++;
    }

    public function getShortCode(): string
    {
        return $this->shortCode;
    }

    public function getOriginalUrl(): string
    {
        return $this->originalUrl;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getClicks(): int
    {
        return $this->clicks;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }
}
