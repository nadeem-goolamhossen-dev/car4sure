<?php

namespace App\Service\Vehicle;

use App\Entity\Policy;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Repository\PolicyRepository;
use App\Repository\UserRepository;
use App\Repository\VehicleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

    public function getVehicles(array $options = [])
    {
        return $this->vehicleRepository->findAllWithOptions($options);
    }

    public function getVehicle(array $options = [])
    {
        return $this->vehicleRepository->findOneWithOptions($options);
    }

    /**
     * Save user.
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
     * Delete policy.
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