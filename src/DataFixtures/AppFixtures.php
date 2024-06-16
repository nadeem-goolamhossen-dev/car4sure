<?php

namespace App\DataFixtures;

use App\Entity\Policy;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @var Generator
     */
    private Generator $faker;

    /**
     * @var array List of users
     */
    private array $userList = [];

    private ?User $admin = null;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->faker = Factory::create();
    }

    /**
     * Load fixtures
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // Create list of users
        $this->createUsers($manager);

        // Create list of policies
        $this->createPolicies($manager);
    }

    /**
     * Create list of users.
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function createUsers(ObjectManager $manager): void
    {
        // Create admin user
        $this->admin = new User();
        $this->admin
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('goolamhossen.nadeem@gmail.com')
            ->setPassword($this->passwordHasher->hashPassword($this->admin, 'admin'))
            ->setFirstname('Nadeem')
            ->setLastname('Goolam Hossen')
            ->setActive(true)
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
        ;

        $manager->persist($this->admin);

        // Create dummy users
        for ($u = 1; $u <= 5; $u++) {
            $user = new User();
            $user
                ->setRoles(['ROLE_USER'])
                ->setEmail(sprintf('user%02d@gmail.com', ($u)))
                ->setPassword($this->passwordHasher->hashPassword($user, 'user'))
                ->setFirstname($this->faker->firstName)
                ->setLastname($this->faker->lastName)
                ->setActive(true)
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime())
                ->setCreatedBy($this->admin)
                ->setUpdatedBy($this->admin)
            ;

            $manager->persist($user);

            // Keep in array
            $this->userList[] = $user;
        }

        $manager->flush();
    }

    /**
     * Create list of policies.
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function createPolicies(ObjectManager $manager): void
    {
        for ($p = 1; $p <= 5; $p++) {
            $dateNow = $this->faker->dateTime;
            $startDate = $dateNow->modify('-10 years');
            $endDate = (clone $startDate)->modify('+1 years');

            $policy = new Policy();
            $policy
                ->setPolicyNo($p)
                ->setType('Auto')
                ->setStatus(true)
                ->setEffectiveDate($startDate)
                ->setExpirationDate($endDate)
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime())
                ->setCreatedBy($this->admin)
                ->setUpdatedBy($this->admin)
            ;

            $manager->persist($policy);
        }

        $manager->flush();
    }
}
