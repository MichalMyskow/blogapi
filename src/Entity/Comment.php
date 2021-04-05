<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}},
 *     itemOperations={
 *       "get",
 *       "put",
 *       "delete"
 *     },
 *     collectionOperations={
 *          "get",
 *          "post"
 *     }
 * )
 * @ORM\Table(name="comment")
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var int
     *
     * @Groups({"read"})
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string
     *
     * @Groups({"read", "write"})
     *
     * @ORM\Column(name="content", type="text", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var bool
     *
     * @Groups({"read"})
     *
     * @ORM\Column(name="description", type="boolean", nullable=false)
     * @Assert\NotBlank()
     */
    private $approved;

    /**
     * @var DateTimeInterface
     *
     * @Groups({"read"})
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    private $createdAt;

    /**
     * @var Post
     *
     * @Groups({"read", "write"})
     *
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $name): self
    {
        $this->content = $name;

        return $this;
    }

    public function getApproved(): bool
    {
        return $this->approved;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getOwner(): ?Post
    {
        return $this->owner;
    }

    public function setOwner(?Post $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
