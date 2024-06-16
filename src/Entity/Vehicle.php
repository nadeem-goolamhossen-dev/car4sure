<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use App\Traits\LoggableEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    use LoggableEntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 255)]
    private ?string $make = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $vin = null;

    #[ORM\Column(length: 255)]
    private ?string $vehicleUsage = null;

    #[ORM\Column(length: 255)]
    private ?string $primaryUse = null;

    #[ORM\Column]
    private ?int $annualMilleage = null;

    #[ORM\Column(length: 255)]
    private ?string $ownership = null;

    #[ORM\ManyToOne(targetEntity: Policy::class, inversedBy: 'vehicles')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Policy $policy = null;

    /**
     * @var Collection<int, Coverage>
     */
    #[ORM\ManyToMany(targetEntity: Coverage::class, inversedBy: 'vehicles')]
    private Collection $coverages;

    public function __construct()
    {
        $this->coverages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getMake(): ?string
    {
        return $this->make;
    }

    public function setMake(string $make): static
    {
        $this->make = $make;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(string $vin): static
    {
        $this->vin = $vin;

        return $this;
    }

    public function getVehicleUsage(): ?string
    {
        return $this->vehicleUsage;
    }

    public function setVehicleUsage(string $vehicleUsage): static
    {
        $this->vehicleUsage = $vehicleUsage;

        return $this;
    }

    public function getPrimaryUse(): ?string
    {
        return $this->primaryUse;
    }

    public function setPrimaryUse(string $primaryUse): static
    {
        $this->primaryUse = $primaryUse;

        return $this;
    }

    public function getAnnualMilleage(): ?int
    {
        return $this->annualMilleage;
    }

    public function setAnnualMilleage(int $annualMilleage): static
    {
        $this->annualMilleage = $annualMilleage;

        return $this;
    }

    public function getOwnership(): ?string
    {
        return $this->ownership;
    }

    public function setOwnership(string $ownership): static
    {
        $this->ownership = $ownership;

        return $this;
    }

    public function getPolicy(): ?Policy
    {
        return $this->policy;
    }

    public function setPolicy(?Policy $policy): static
    {
        $this->policy = $policy;

        return $this;
    }

    /**
     * @return Collection<int, Coverage>
     */
    public function getCoverages(): Collection
    {
        return $this->coverages;
    }

    public function addCoverage(Coverage $coverage): static
    {
        if (!$this->coverages->contains($coverage)) {
            $this->coverages->add($coverage);
        }

        return $this;
    }

    public function removeCoverage(Coverage $coverage): static
    {
        $this->coverages->removeElement($coverage);

        return $this;
    }
}
