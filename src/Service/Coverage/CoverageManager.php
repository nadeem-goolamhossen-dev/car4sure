<?php

namespace App\Service\Coverage;

use App\Entity\Coverage;
use App\Repository\CoverageRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Manage Coverage
 */
class CoverageManager
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
     * @var CoverageRepository
     */
    private CoverageRepository $coverageRepository;

    /**
     * Construct
     */
    public function __construct(EntityManagerInterface $manager, Security $security, CoverageRepository $coverageRepository)
    {
        $this->manager = $manager;
        $this->security = $security;
        $this->coverageRepository = $coverageRepository;
    }

    /**
     * Get coverages
     *
     * @param array $options
     *
     * @return mixed
     */
    public function getCoverages(array $options = []): mixed
    {
        return $this->coverageRepository->findAllWithOptions($options);
    }

    /**
     * Get a coverage
     *
     * @param array $options
     *
     * @return Coverage
     */
    public function getCoverage(array $options = []): Coverage
    {
        return $this->coverageRepository->findOneWithOptions($options);
    }

    /**
     * Save coverage.
     *
     * @param Coverage $coverage Coverage to register
     *
     * @throws Exception
     */
    public function save(Coverage $coverage): void
    {
        $coverage
            ->setUpdatedAt(new DateTime())
            ->setUpdatedBy($this->security->getUser())
        ;

        if (is_null($coverage->getId())) {
            $coverage
                ->setCreatedAt(new DateTime())
                ->setCreatedBy($this->security->getUser())
            ;

            $this->manager->persist($coverage);
        }

        $this->manager->flush();
    }

    /**
     * Delete coverage.
     *
     * @param Coverage $coverage Coverage to delete
     *
     * @throws Exception
     */
    public function delete(Coverage $coverage): void
    {
        $this->manager->remove($coverage);
        $this->manager->flush();
    }
}