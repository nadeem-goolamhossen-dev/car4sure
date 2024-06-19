<?php

namespace App\Repository;

use App\Entity\Policy;
use App\Traits\DatalistRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Policy>
 */
class PolicyRepository extends ServiceEntityRepository
{
    use DatalistRepositoryTrait;

    /**
     * Constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Policy::class);
    }

    /**
     * Construct SQL using options.
     *
     * @param array $options
     *
     * @return QueryBuilder
     */
    public function buildQuery(array $options = []): QueryBuilder
    {
        $query = $this->createQueryBuilder('p');

        return $query->orderBy('p.policyNo', 'DESC');
    }

    /**
     * Get last inserted id.
     *
     * @return int
     */
    public function getLastInsertedId(): int
    {
        $result = $this->createQueryBuilder('p')
            ->select('DISTINCT p0.id')
            ->from(Policy::class, 'p0')
            ->orderBy('p0.id', 'DESC')
            ->getQuery()->getArrayResult()
        ;

        $lastInsertedId = 0;

        if (count($result) > 0) {
            $lastInsertedId = $result['0']['id'];
        }

        return $lastInsertedId;
    }
}
