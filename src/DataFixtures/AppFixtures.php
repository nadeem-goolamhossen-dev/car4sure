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
     */
    public function createUsers(ObjectManager $manager)
    {
        // Create dummy users
        for ($u = 1; $u <= 5; $u++) {
            $user = new User();

            if ($u == 1) {
                $user
                    ->setRoles(['ROLE_ADMIN'])
                    ->setEmail('admin@gmail.com')
                    ->setPassword($this->passwordHasher->hashPassword($user,'admin'))
                    ->setCreatedAt(new DateTime())
                    ->setUpdatedAt(new DateTime())
                ;

                $this->admin = $user;
            } else {
                $email = 'user' . $u . '@gmail.com';
                $user
                    ->setRoles(['ROLE_USER'])
                    ->setEmail($email)
                    ->setPassword($this->passwordHasher->hashPassword($user,'user'))
                    ->setCreatedAt(new DateTime())
                    ->setUpdatedAt(new DateTime())
                    ->setCreatedBy($this->admin)
                    ->setUpdatedBy($this->admin)
                ;
            }

            $manager->persist($user);

            // Keep in array
            $this->userList[] = $user;
        }

        $manager->flush();
    }
}
