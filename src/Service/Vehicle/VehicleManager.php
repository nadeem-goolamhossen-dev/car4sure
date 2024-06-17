<?php

namespace App\Service\Vehicle;

use App\Entity\Vehicle;
use App\Repository\VehicleRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Manage Vehicle
 */
class VehicleManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * @var VehicleRepository
     */
    private VehicleRepository $vehicleRepository;

    /**
     * Construct
     */
    public function __construct(EntityManagerInterface $manager, Security $security, VehicleRepository $vehicleRepository)
    {
        $this->manager = $manager;
        $this->security = $security;
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Count vehicles
     *
     * @return int
     */
    public function getVehiclesCount(): int
    {
        return count($this->vehicleRepository->findAll());
    }

    /**
     * Get vehicles
     *
     * @param array $options
     *
     * @return ArrayCollection
     */
    public function getVehicles(array $options = []): ArrayCollection
    {
        return $this->vehicleRepository->findAllWithOptions($options);
    }

    /**
     * Get a vehicle
     *
     * @param array $options
     *
     * @return Vehicle
     */
    public function getVehicle(array $options = []): Vehicle
    {
        return $this->vehicleRepository->findOneWithOptions($options);
    }

    /**
     * Save vehicle.
     *
     * @param Vehicle $vehicle Vehicle to register
     *
     * @throws Exception
     */
    public function save(Vehicle $vehicle): void
    {
        $vehicle
            ->setUpdatedAt(new DateTime())
            ->setUpdatedBy($this->security->getUser())
        ;

        if (is_null($vehicle->getId())) {
            $vehicle
                ->setCreatedAt(new DateTime())
                ->setCreatedBy($this->security->getUser())
            ;

            $this->manager->persist($vehicle);
        }

        $this->manager->flush();
    }

    /**
     * Delete vehicle.
     *
     * @param Vehicle $vehicle Vehicle to delete
     *
     * @throws Exception
     */
    public function delete(Vehicle $vehicle): void
    {
        $this->manager->remove($vehicle);
        $this->manager->flush();
    }
}