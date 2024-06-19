<?php

namespace App\Entity;

use App\Repository\PolicyRepository;
use App\Traits\LoggableEntityTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PolicyRepository::class)]
#[ORM\Table(name: '`policy`')]
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

    /**
     * @var Collection<int, Vehicle>
     */
    #[ORM\OneToMany(targetEntity: Vehicle::class, mappedBy: 'policy', cascade: ['persist'])]
    private Collection $vehicles;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Person $holder = null;

    /**
     * @var Collection<int, Person>
     */
    #[ORM\OneToMany(targetEntity: Person::class, mappedBy: 'policy')]
    private Collection $drivers;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
        $this->drivers = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
            $vehicle->setPolicy($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            // set the owning side to null (unless already changed)
            if ($vehicle->getPolicy() === $this) {
                $vehicle->setPolicy(null);
            }
        }

        return $this;
    }

    public function getHolder(): ?Person
    {
        return $this->holder;
    }

    public function setHolder(?Person $holder): static
    {
        $this->holder = $holder;

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getDrivers(): Collection
    {
        return $this->drivers;
    }

    public function addDriver(Person $driver): static
    {
        if (!$this->drivers->contains($driver)) {
            $this->drivers->add($driver);
            $driver->setPolicy($this);
        }

        return $this;
    }

    public function removeDriver(Person $driver): static
    {
        if ($this->drivers->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getPolicy() === $this) {
                $driver->setPolicy(null);
            }
        }

        return $this;
    }
}
