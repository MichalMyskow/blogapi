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
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @Groups({"read", "write"})
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     *
     * @Groups({"read", "write"})
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @var string
     *
     * @Groups({"read", "write"})
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @Groups({"read", "write"})
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @var datetime
     *
     * @Groups({"read", "write"})
     *
     * @ORM\Column(type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    private $registeredAt;

    /**
     * @var bool
     *
     * @Groups({"read", "write"})
     *
     * @ORM\Column(type="boolean", nullable=false)
     * @Assert\NotBlank()
     */
    private $verified;

    /**
     * @var datetime
     *
     * @Groups({"read", "write"})
     *
     * @ORM\Column(type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    private $lastLogin;

    /**
     * @var bool
     *
     * @Groups({"read", "write"})
     *
     * @ORM\Column(type="boolean", nullable=false)
     * @Assert\NotBlank()
     */
    private $isAuthor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRegisteredAt(): ?DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(DateTimeInterface $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getVerified(): ?bool
    {
        return $this->verified;
    }

    public function setVerified(bool $verified): self
    {
        $this->verified = $verified;

        return $this;
    }

    public function getLastLogin(): ?DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function __construct()
    {
        $this->lastLogin = new DateTimeImmutable();
        $this->registeredAt = new DateTimeImmutable();
    }

    public function setLastLogin(DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getIsAuthor(): ?bool
    {
        return $this->isAuthor;
    }

    public function setIsAuthor(bool $isAuthor): self
    {
        $this->isAuthor = $isAuthor;

        return $this;
    }
}
