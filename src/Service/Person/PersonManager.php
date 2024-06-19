<?php

namespace App\Service\Person;

use App\Entity\Person;
use App\Entity\Policy;
use App\Repository\PersonRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Manage Person
 */
class PersonManager
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
     * @var PersonRepository
     */
    private PersonRepository $personRepository;

    /**
     * Construct
     */
    public function __construct(EntityManagerInterface $manager, Security $security, PersonRepository $personRepository)
    {
        $this->manager = $manager;
        $this->security = $security;
        $this->personRepository = $personRepository;
    }

    /**
     * Count person
     *
     * @return int
     */
    public function getPersonsCount(): int
    {
        return count($this->personRepository->findAll());
    }

    /**
     * Get persons
     *
     * @param array $options
     *
     * @return mixed
     */
    public function getPersons(array $options = []): mixed
    {
        return $this->personRepository->findAllWithOptions($options);
    }

    /**
     * Get a person
     *
     * @param array $options
     *
     * @return Policy
     */
    public function getPerson(array $options = []): Policy
    {
        return $this->personRepository->findOneWithOptions($options);
    }

    /**
     * Save person.
     *
     * @param Person $person Person to register
     *
     * @throws Exception
     */
    public function save(Person $person): void
    {
        $person
            ->setUpdatedAt(new DateTime())
            ->setUpdatedBy($this->security->getUser())
        ;

        if (is_null($person->getId())) {
            $person
                ->setCreatedAt(new DateTime())
                ->setCreatedBy($this->security->getUser())
            ;

            $this->manager->persist($person);
        }

        $this->manager->flush();
    }

    /**
     * Delete person.
     *
     * @param Person $person Person to delete
     *
     * @throws Exception
     */
    public function delete(Person $person): void
    {
        $this->manager->remove($person);
        $this->manager->flush();
    }
}