<?php

namespace App\DataFixtures;

use App\Constant\Coverage\CoverageConstant;
use App\Constant\Person\PersonConstant;
use App\Entity\Address;
use App\Entity\Coverage;
use App\Entity\License;
use App\Entity\Person;
use App\Entity\Policy;
use App\Entity\User;
use App\Entity\Vehicle;
use DateInterval;
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
    private array $users = [];

    /**
     * @var array List of persons
     */
    private array $persons = [];

    /**
     * @var array List of vehicles
     */
    private array $policies = [];

    /**
     * @var array List of coverages
     */
    private array $coverages = [];

    /**
     * @var array List of vehicles
     */
    private array $vehicles = [];

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

        // Create list of coverages
        $this->createCoverages($manager);

        // Create list of vehicles
        $this->createVehicles($manager);

        // Create list of persons
        //$this->createPersons($manager);

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
        $admin = new User();
        $admin
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('goolamhossen.nadeem@gmail.com')
            ->setPassword($this->passwordHasher->hashPassword($admin, 'admin'))
            ->setFirstname('Nadeem')
            ->setLastname('Goolam Hossen')
            ->setActive(true)
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
            ->setCreatedBy($admin)
            ->setUpdatedBy($admin)
        ;

        $manager->persist($admin);

        $this->users[] = $admin;

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
                ->setCreatedBy($this->faker->randomElement($this->users))
                ->setUpdatedBy($this->faker->randomElement($this->users))
            ;

            $manager->persist($user);

            // Keep in array
            $this->users[] = $user;
        }

        $manager->flush();
    }

    /**
     * Create list of coverages.
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function createCoverages(ObjectManager $manager): void
    {
        $coverages = CoverageConstant::TYPES;

        for ($c = 0; $c < count($coverages); $c++) {
            $coverage = new Coverage();
            $coverage
                ->setType($coverages[$c])
                ->setCoverLimit(25000)
                ->setDeductible(500)
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime())
                ->setCreatedBy($this->faker->randomElement($this->users))
                ->setUpdatedBy($this->faker->randomElement($this->users))
            ;

            $manager->persist($coverage);

            // Keep in array
            $this->coverages[] = $coverage;
        }

        $manager->flush();
    }

    /**
     * Create list of coverages.
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function createVehicles(ObjectManager $manager): void
    {
        for ($v = 1; $v < 5; $v++) {
            // Create garaging address
            $address = new Address();
            $address
                ->setStreet($this->faker->streetAddress)
                ->setCity($this->faker->city)
                ->setState($this->faker->countryCode)
                ->setZip($this->faker->numerify('#####'))
            ;

            $vehicle = new Vehicle();
            $vehicle
                ->setYear($this->faker->year)
                ->setMake($this->faker->realText(10))
                ->setModel($this->faker->realText(10))
                ->setVin($this->faker->numerify('#################'))
                ->setVehicleUsage($this->faker->realText(10))
                ->setPrimaryUse($this->faker->realText(15))
                ->setAnnualMilleage($this->faker->numberBetween(1000, 50000))
                ->setOwnership($this->faker->randomElement(['leased', 'owned']))
                ->setGaragingAddress($address)
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime())
                ->setCreatedBy($this->faker->randomElement($this->users))
                ->setUpdatedBy($this->faker->randomElement($this->users))
            ;

            // Add coverages to vehicle
            $randomNum = $this->faker->numberBetween(1, count($this->coverages));

            for ($vc = 1; $vc < $randomNum; $vc++) {
                $vehicle->addCoverage($this->coverages[$vc]);
            }

            $manager->persist($vehicle);

            // Keep in array
            $this->vehicles[] = $vehicle;
        }

        $manager->flush();
    }

    public function createPersons(ObjectManager $manager): void
    {
        for ($c = 1; $c <= 5; $c++) {
            // Create person address
            $address = new Address();
            $address
                ->setStreet($this->faker->streetAddress)
                ->setCity($this->faker->city)
                ->setState($this->faker->countryCode)
                ->setZip($this->faker->numerify('#####'))
            ;

            $gender = $this->faker->randomElement(PersonConstant::GENDERS);
            $firstname = ($gender == 'M') ? $this->faker->firstNameMale : $this->faker->firstNameFemale;

            $policyHolder = new Person();
            $policyHolder
                ->setFirstname($firstname)
                ->setLastname($this->faker->lastName)
                ->setGender($gender)
                ->setAge($this->faker->numberBetween(20, 35))
                ->setMaritalStatus($this->faker->randomElement(['Single', 'Married']))
                ->setPersonAddress($address)
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime())
                ->setCreatedBy($this->faker->randomElement($this->users))
                ->setUpdatedBy($this->faker->randomElement($this->users))
            ;

            $manager->persist($policyHolder);
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

            // Create person address
            $address = new Address();
            $address
                ->setStreet($this->faker->streetAddress)
                ->setCity($this->faker->city)
                ->setState($this->faker->countryCode)
                ->setZip($this->faker->numerify('#####'))
            ;

            $gender = $this->faker->randomElement(PersonConstant::GENDERS);
            $firstname = ($gender == 'M') ? $this->faker->firstNameMale : $this->faker->firstNameFemale;

            $policyHolder = new Person();
            $policyHolder
                ->setFirstname($firstname)
                ->setLastname($this->faker->lastName)
                ->setGender($gender)
                ->setAge($this->faker->numberBetween(20, 35))
                ->setMaritalStatus($this->faker->randomElement(['Single', 'Married']))
                ->setPersonAddress($address)
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime())
                ->setCreatedBy($this->faker->randomElement($this->users))
                ->setUpdatedBy($this->faker->randomElement($this->users))
            ;

            // Get chance of creating a licence
            $hasLicence = $this->faker->boolean(60);

            if ($hasLicence) {
                $effectiveDate = $this->faker->dateTime;
                $expiryDate = (clone $effectiveDate)->add(new DateInterval('P1Y'));
                $isActive = $expiryDate->format('Y-m-d') > $effectiveDate->format('Y-m-d');

                // Create license
                $license = new License();
                $license
                    ->setNumber($this->faker->unique()->numerify('#######'))
                    ->setState($address->getState())
                    ->setClass(strtoupper($this->faker->randomLetter))
                    ->setStatus($isActive)
                    ->setEffectiveDate($effectiveDate)
                    ->setExpirationDate($expiryDate)
                ;
                /*$license
                    ->setNumber($this->faker->unique()->numerify('#######'))
                    ->setState($address->getState())
                    ->setClass(strtoupper($this->faker->randomLetter))
                    ->setStatus($isActive ?? true)
                    ->setEffectiveDate(new DateTime())
                    ->s(new DateTime())
                    ->setCreatedAt(new DateTime())
                    ->setUpdatedAt(new DateTime())
                    ->setCreatedBy($this->faker->randomElement($this->users))
                    ->setUpdatedBy($this->faker->randomElement($this->users))
                ;*/

                $policyHolder->setPersonLicense($license);
            }

            // Creat dummy policy
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
                ->setHolder($policyHolder)
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime())
                ->setCreatedBy($this->faker->randomElement($this->users))
                ->setUpdatedBy($this->faker->randomElement($this->users))
            ;

            // Add vehicles to policy
            $randomNum = $this->faker->numberBetween(1, count($this->vehicles) - 1);

            for ($pv = 1; $pv <= $randomNum; $pv++) {
                $policy->addVehicle($this->vehicles[$pv]);
            }

            $manager->persist($policy);
        }

        $manager->flush();
    }
}
