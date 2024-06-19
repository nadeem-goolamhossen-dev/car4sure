<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use App\Traits\LoggableEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ORM\Table(name: '`person`')]
class Person
{
    use LoggableEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Please enter a valid firstname')]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Please enter a valid lastname')]
    private ?string $lastname = null;

    #[ORM\Column(length: 1)]
    private ?string $gender = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Please enter a valid age')]
    #[Assert\GreaterThanOrEqual(20, message: 'Age must not be less than 20')]
    #[Assert\LessThanOrEqual(35, message: 'Age must not be more than 35')]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    private ?string $maritalStatus = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Address $personAddress = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?License $personLicense = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return strtoupper($this->lastname);
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getMaritalStatus(): ?string
    {
        return $this->maritalStatus;
    }

    public function setMaritalStatus(string $maritalStatus): static
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    public function getPersonAddress(): ?Address
    {
        return $this->personAddress;
    }

    public function setPersonAddress(?Address $personAddress): static
    {
        $this->personAddress = $personAddress;

        return $this;
    }

    public function getPersonLicense(): ?License
    {
        return $this->personLicense;
    }

    public function setPersonLicense(?License $personLicense): static
    {
        $this->personLicense = $personLicense;

        return $this;
    }

    public function getFullname(): string
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }
}