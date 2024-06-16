<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Manage Users
 */
class UserManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * Construct
     */
    public function __construct(EntityManagerInterface $manager, Security $security, UserRepository $userRepository,
                                UserPasswordHasherInterface $passwordHasher)
    {
        $this->manager = $manager;
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->passwordHasher = $passwordHasher;
    }

    public function getUsers(array $options = [])
    {
        return $this->userRepository->findAllWithOptions($options);
    }

    public function getUser(array $options = [])
    {
        return $this->userRepository->findOneWithOptions($options);
    }

    /**
     * Save user.
     *
     * @param User $user User to register
     *
     * @throws Exception
     */
    public function save(User $user): void
    {
        $user
            ->setUpdatedAt(new DateTime())
            ->setUpdatedBy($this->security->getUser())
        ;

        if (is_null($user->getId())) {
            $user
                ->setPassword($this->passwordHasher->hashPassword($user, 'user'))
                ->setCreatedAt(new DateTime())
                ->setCreatedBy($this->security->getUser())
            ;

            $this->manager->persist($user);
        }

        $this->manager->flush();
    }

    /**
     * Delete user.
     *
     * @param User $user User to delete
     *
     * @throws Exception
     */
    public function delete(User $user): void
    {
        // Prevent deleting admin
        if ($user->getId() === 1) {
            throw new Exception(sprintf('This user cannot be deleted.'));
        }

        // Delete user
        $this->manager->remove($user);
        $this->manager->flush();
    }
}