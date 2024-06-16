<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Traits\LoggableEntityTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Email already exists')]
#[ORM\Table(name: '`user`')]
#[ORM\Index(name: "email_idx", columns: ["email"])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'], )]

#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap(['user' => 'App\Entity\User'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use LoggableEntityTrait;

    /**
     * User id
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * User email
     *
     * @var string
     */
    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: "Please enter a valid email address.")]
    #[Assert\Email(message: "Please enter a valid email address.")]
    private string $email;

    /**
     * User roles
     *
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * User hashed password
     *
     * @var string
     */
    #[ORM\Column]
    private string $password;

    /**
     * Firstname of user
     *
     * @var string
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter firstname")]
    private string $firstname;

    /**
     * Lastname of user
     *
     * @var string
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter lastname")]
    private string $lastname;

    /**
     * Check if user is active
     *
     * @var bool
     */
    #[ORM\Column(type: "boolean")]
    public bool $isActive = false;

    /**
     * Return id of user.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Return email of user.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return mb_strtolower($this->email);
    }

    /**
     * Set user email.
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): static
    {
        $this->email = mb_strtolower($email);

        return $this;
    }

    /**
     * Return fullname of user
     *
     * @return string
     */
    public function getFullname(): string
    {
        return $this->getLastname() . ' ' . $this->getFirstname();
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * Get user roles
     *
     * @see UserInterface
     *
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Set user roles
     *
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get user password
     *
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set user password.
     *
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get user firstname
     *
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Set user firstname
     *
     * @param string $firstname
     *
     * @return $this
     */
    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get user lastname
     *
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return mb_strtoupper($this->lastname);
    }

    /**
     * Set user lastname
     *
     * @param string $lastname
     *
     * @return $this
     */
    public function setLastname(string $lastname): static
    {
        $this->lastname = mb_strtoupper($lastname);

        return $this;
    }

    /**
     * Get active status of user
     *
     * @return bool|null
     */
    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * Set active status of user
     *
     * @param bool|null $isActive
     *
     * @return $this
     */
    public function setActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Allows to erase sensible data stored temporarily
     *
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
