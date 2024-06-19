<?php

namespace App\Service\Policy;

use App\Entity\Policy;
use App\Repository\PolicyRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;

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

    /**
     * Count policies
     *
     * @return int
     */
    public function getPoliciesCount(): int
    {
        return count($this->policyRepository->findAll());
    }

    /**
     * Get poliies
     *
     * @param array $options
     *
     * @return mixed
     */
    public function getPolicies(array $options = []): mixed
    {
        return $this->policyRepository->findAllWithOptions($options);
    }

    /**
     * Get a policy
     *
     * @param array $options
     *
     * @return Policy
     */
    public function getPolicy(array $options = []): Policy
    {
        return $this->policyRepository->findOneWithOptions($options);
    }

    /**
     * Save policy.
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