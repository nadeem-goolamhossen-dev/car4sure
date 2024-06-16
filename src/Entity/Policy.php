<?php

namespace App\Entity;

use App\Repository\PolicyRepository;
use App\Traits\LoggableEntityTrait;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PolicyRepository::class)]
class Policy
{
    use LoggableEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $policyNo = null;

    #[ORM\Column]
    private ?bool $status = false;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $effectiveDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $expirationDate = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPolicyNo(): ?int
    {
        return $this->policyNo;
    }

    public function setPolicyNo(int $policyNo): static
    {
        $this->policyNo = $policyNo;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEffectiveDate(): ?DateTimeInterface
    {
        return $this->effectiveDate;
    }

    public function setEffectiveDate(DateTimeInterface $effectiveDate): static
    {
        $this->effectiveDate = $effectiveDate;

        return $this;
    }

    public function getExpirationDate(): ?DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(DateTimeInterface $expirationDate): static
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }
}
