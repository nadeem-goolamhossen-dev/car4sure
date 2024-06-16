<?php

namespace App\Repository;

use App\Entity\Policy;
use App\Traits\DatalistRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Policy>
 */
class PolicyRepository extends ServiceEntityRepository
{
    use DatalistRepositoryTrait;

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

        // Total
        if (!empty($options['total'])) {
            $query->select('count(p)');
        }

        return $query->orderBy('p.policyNo', 'DESC');
    }

    public function getLastInsertedId(): int
    {
        return $this->createQueryBuilder('p')
            ->select('p0.id')
            ->from(Policy::class, 'p0')
            ->orderBy('p0.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()->getSingleScalarResult()
        ;
    }

    //    /**
    //     * @return Policy[] Returns an array of Policy objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Policy
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
