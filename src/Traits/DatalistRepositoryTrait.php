<?php

namespace App\Traits;

trait DatalistRepositoryTrait
{
    /**
     * Construct SQL using options.
     *
     * @param array $options Options
     *
     * @return mixed Requête
     */
    abstract public function buildQuery(array $options = []): mixed;

    /**
     * Return the number of records found using options.
     *
     * @param array $options Options
     *
     * @return int Number of records
     */
    public function countAllWithOptions(array $options = []): int
    {
        $query = $this->buildQuery($options + [
            'total' => true,
        ]);

        return $query->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * Return list of records found using options.
     *
     * @param array $options Options
     *
     * @return mixed Records
     */
    public function findAllWithOptions(array $options = []): mixed
    {
        $query = $this->buildQuery($options);

        // Limit
        if (!empty($options['limit'])) {
            $query->setMaxResults($options['limit']);
        }

        return $query->getQuery()
            ->getResult()
        ;
    }

    /**
     * Return a single record found or null.
     *
     * @param array $options Options
     *
     * @return mixed
     */
    public function findOneWithOptions(array $options = []): mixed
    {
        $query = $this->buildQuery($options);

        return $query->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}