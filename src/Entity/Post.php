<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
class Post
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
     * @ORM\Column(name="title", type="text", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $title;

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
     * @var DateTimeInterface
     *
     * @Groups({"read"})
     *
     * @ORM\Column(name="published_at", type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    private $publishedAt;

    /**
     * @var bool
     *
     * @Groups({"read"})
     *
     * @ORM\Column(name="published", type="boolean", nullable=false)
     * @Assert\NotBlank()
     */
    private $published;

    /**
     * @var bool
     *
     * @Groups({"read"})
     *
     * @ORM\Column(name="comments_active", type="boolean", nullable=false)
     * @Assert\NotBlank()
     */
    private $commentsActive;

    /**
     * @Groups({"read"})
     *
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="owner")
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->publishedAt = new DateTimeImmutable();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $name): self
    {
        $this->title = $name;

        return $this;
    }

    public function getPublishedAt(): DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
    }

    /**
     * @Groups("read")
     */
    public function getSummary(): ?string
    {
        if (strlen($this->content) < 40) {
            return $this->content;
        }

        return substr($this->content, 0, 40).'...';
    }

    public function isCommentsActive(): bool
    {
        return $this->commentsActive;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setOwner($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getOwner() === $this) {
                $comment->setOwner(null);
            }
        }

        return $this;
    }
}
