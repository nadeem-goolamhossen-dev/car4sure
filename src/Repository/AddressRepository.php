<?php

namespace App\Repository;

use App\Entity\Address;
use App\Traits\DatalistRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Address>
 */
class AddressRepository extends ServiceEntityRepository
{
    use DatalistRepositoryTrait;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    /**
     * Construct SQL using options
     *
     * @param array $options
     *
     * @return QueryBuilder
     */
    public function buildQuery(array $options = []): QueryBuilder
    {
        return $this->createQueryBuilder('a');
    }
}
