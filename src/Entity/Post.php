<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
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
 *       "put"={"security"="is_granted('ROLE_AUTHOR') or object.owner == user"},
 *       "delete"
 *     },
 *     collectionOperations={
 *          "get",
 *          "post"
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"published"})
 * @ApiFilter(SearchFilter::class, properties={"title": "partial"})
 * @ORM\Table(name="post")
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
     * @ORM\Column(name="published_at", type="datetime", nullable=true)
     */
    private $publishedAt;

    /**
     * @var bool
     *
     * @Groups({"read", "write"})
     *
     * @ORM\Column(name="published", type="boolean", nullable=false)
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     */
    private $published = false;

    /**
     * @var bool
     *
     * @Groups({"read", "write"})
     *
     * @ORM\Column(name="comments_active", type="boolean", nullable=false)
     * @Assert\Type(type="bool")
     * @Assert\NotNull()
     */
    private $commentsActive;

    /**
     * @var Comment[]
     *
     * @Groups({"read"})
     *
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="post")
     */
    private $comments;

    /**
     * @var User
     *
     * @Groups ({"read", "write"})
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     * @ORM\JoinColumn(name="user_id", nullable=false)
     * @Assert\NotBlank()
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="posts")
     * @ORM\JoinTable(name="post_to_tag")
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="posts")
     * @ORM\JoinTable(name="post_to_category")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="likedPosts")
     * @ORM\JoinTable(name="likes")
     */
    private $likes;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->likes = new ArrayCollection();
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

    public function getPublishedAt(): ?DateTimeInterface
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

        return $this;
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

    public function setCommentsActive(bool $commentsActive): self
    {
        $this->commentsActive = $commentsActive;

        return $this;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;
        if ($published) {
            $this->publishedAt = new DateTimeImmutable();
        }

        return $this;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
        }

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        $this->likes->removeElement($like);

        return $this;
    }
}
