<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setFirstname('gaetan')
            ->setSurname('boyron')
            ->setUsername('admin')
            ->setEmail('gaetan.boyron@gmail.com')
            ->setPassword($this->encoder->encodePassword($adminUser, 'password'))
            ->addUserRole($adminRole);

        $manager->persist($adminUser);

        $users = [];
        $locations = [];
        /* creation des adresses*/
        for ($i=0; $i < 50; $i++){
            $location = new Location();

            $location->setDepartment($faker->departmentName)
                ->setPostCode($faker->postcode)
                ->setRegion($faker->region)
                ->setCountry($faker->country)
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setLatitude($faker->latitude)
                ->setLongitude($faker->longitude)
            ;
            $manager->persist($location);
            $locations[] = $location;
        }

        /* creation des utilisateurs*/
        for ($i=0; $i < 50; $i++){
            $user = new User();

            $location = $locations[mt_rand(0, count($locations) - 1)];

            $user->setSurname($faker->name)
                ->setFirstname($faker->firstName)
                ->setUsername($faker->userName)
                ->setBirthdayAt($faker->dateTimeBetween($startDate = '-30 years', $endDate = '-3 years'))
                ->setLocation($location)
                ->setEmail($faker->email)
                ->setCreatedAt($faker->dateTime($max = 'now', $timezone = null))
                ->setBiography($faker->text)
                ->setPassword($this->encoder->encodePassword($user, 'password'))
            ;
            $manager->persist($user);
            $users[] = $user;
        }

        $manager->flush();
    }
}
