<?php

namespace App\DataFixtures;

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

    /**
     * @var User|null
     */
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
        // Create dummy users
        for ($u = 1; $u <= 5; $u++) {
            $roles = ($u == 1) ? ['ROLE_ADMIN'] : ['ROLE_USER'];
            $email = ($u == 1) ? 'admin@gmail.com' : sprintf('user%02d@gmail.com', ($u - 1));
            $password = ($u == 1) ? 'admin' : 'user';


            $user = new User();
            $user
                ->setRoles($roles)
                ->setEmail($email)
                ->setPassword($this->passwordHasher->hashPassword($user,$password))
                ->setFirstname($this->faker->firstName)
                ->setLastname($this->faker->lastName)
                ->setActive(true)
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime())
            ;

            if ($u == 1) {
                $this->admin = $user;
            }

            $user
                ->setCreatedBy($this->admin)
                ->setUpdatedBy($this->admin)
            ;

            $manager->persist($user);

            // Keep in array
            $this->userList[] = $user;
        }

        $manager->flush();
    }
}
