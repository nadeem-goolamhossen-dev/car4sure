<?php

namespace App\Entity;

use App\Repository\CoverageRepository;
use App\Traits\LoggableEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoverageRepository::class)]
class Coverage
{
    use LoggableEntityTrait;

    const TYPE_LIABILITY = 'liability';

    const TYPE_COLLISION = 'collision';

    const TYPE_COMPREHENSIVE = 'comprehensive';

    const TYPES = [self::TYPE_LIABILITY, self::TYPE_COLLISION, self::TYPE_COMPREHENSIVE];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $coverLimit = null;

    #[ORM\Column]
    private ?int $deductible = null;

    /**
     * @var Collection<int, Vehicle>
     */
    #[ORM\ManyToMany(targetEntity: Vehicle::class, mappedBy: 'coverages')]
    private Collection $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCoverLimit(): ?int
    {
        return $this->coverLimit;
    }

    public function setCoverLimit(int $coverLimit): static
    {
        $this->coverLimit = $coverLimit;

        return $this;
    }

    public function getDeductible(): ?int
    {
        return $this->deductible;
    }

    public function setDeductible(int $deductible): static
    {
        $this->deductible = $deductible;

        return $this;
    }

    /**
     * Get all possible types.
     *
     * @return array
     */
    public static function getTypes(): array
    {
        return self::TYPES;
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
            $vehicle->addCoverage($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            $vehicle->removeCoverage($this);
        }

        return $this;
    }

    public function getLabel()
    {
        return $this->type . ' (limit: ' . $this->coverLimit . ', deductible: ' . $this->deductible . ')';
    }
}
