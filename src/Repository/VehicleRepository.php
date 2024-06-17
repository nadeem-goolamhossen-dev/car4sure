<?php

namespace App\Repository;

use App\Entity\Vehicle;
use App\Traits\DatalistRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicle>
 */
class VehicleRepository extends ServiceEntityRepository
{
    use DatalistRepositoryTrait;

    /**
     * Constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
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
        $query = $this->createQueryBuilder('v');

        // Total
        if (!empty($options['total'])) {
            $query->select('count(v)');
        }

        // Conditions
        if (isset($options['hasPolicy'])) {
            $query = $this->hasPolicyCondition($query, $options['hasPolicy']);
        }

        return $query->orderBy('v.year', 'DESC');
    }

    /**
     * Add to SQL a clause to fetch only vehicles
     *
     * @param QueryBuilder $query
     * @param $hasPolicy
     *
     * @return QueryBuilder
     */
    public function hasPolicyCondition(QueryBuilder $query, $hasPolicy):QueryBuilder
    {
        if (!$hasPolicy) {
            $query = $query->andWhere($query->expr()->isNull('v.policy'));
        } else {
            $query = $query->andWhere($query->expr()->isNotNull('v.policy'));
        }

        return $query;
    }
}
