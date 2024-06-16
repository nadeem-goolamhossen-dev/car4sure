<?php

namespace App\Service\Policy;

use App\Entity\Policy;
use App\Entity\User;
use App\Repository\PolicyRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Manage Policy
 */
class PolicyManager
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
     * @var PolicyRepository
     */
    private PolicyRepository $policyRepository;

    /**
     * Construct
     */
    public function __construct(EntityManagerInterface $manager, Security $security, PolicyRepository $policyRepository)
    {
        $this->manager = $manager;
        $this->security = $security;
        $this->policyRepository = $policyRepository;
    }

    public function getPolicies(array $options = [])
    {
        return $this->policyRepository->findAllWithOptions($options);
    }

    public function getPolicy(array $options = [])
    {
        return $this->policyRepository->findOneWithOptions($options);
    }

    /**
     * Save user.
     *
     * @param Policy $policy Policy to register
     *
     * @throws Exception
     */
    public function save(Policy $policy): void
    {
        $policy
            ->setUpdatedAt(new DateTime())
            ->setUpdatedBy($this->security->getUser())
        ;

        if (is_null($policy->getId())) {
            $policyNumber = $this->policyRepository->getLastInsertedId() + 1;
            $policy
                ->setPolicyNo($policyNumber)
                ->setCreatedAt(new DateTime())
                ->setCreatedBy($this->security->getUser())
            ;

            $this->manager->persist($policy);
        }

        $this->manager->flush();
    }

    /**
     * Delete policy.
     *
     * @param Policy $policy Policy to delete
     *
     * @throws Exception
     */
    public function delete(Policy $policy): void
    {
        $this->manager->remove($policy);
        $this->manager->flush();
    }
}