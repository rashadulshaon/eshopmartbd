<?php

namespace App\Entity;

use App\Enum\RoleTypeEnum;
use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Email()]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[Assert\Length(
        min: 6,
        // max: 50,
        minMessage: 'Password must be at least {{ limit }} characters!',
        // maxMessage: 'Your password cannot be longer than {{ limit }} characters',
    )]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 255)]
    private ?RoleTypeEnum $type = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $passwordUpdatedAt = null;

    public function __construct()
    {
        $this->type = RoleTypeEnum::User;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return 'user - ' . $this->email;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        switch ($this->type) {
            case RoleTypeEnum::Admin:
                $roles[] = 'ROLE_ADMIN';
                break;
            case RoleTypeEnum::User:
                $roles[] = 'ROLE_USER';
                break;
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        if ($plainPassword) {
            $this->setPasswordUpdatedAt(new \DateTimeImmutable());
        }

        return $this;
    }

    public function getType(): ?RoleTypeEnum
    {
        return $this->type;
    }

    public function setType(RoleTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPasswordUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->passwordUpdatedAt;
    }

    public function setPasswordUpdatedAt(?\DateTimeImmutable $passwordUpdatedAt): self
    {
        $this->passwordUpdatedAt = $passwordUpdatedAt;

        return $this;
    }
}
