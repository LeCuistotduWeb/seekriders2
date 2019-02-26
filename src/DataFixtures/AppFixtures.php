<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Role;
use App\Entity\Spot;
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

        $userRole = new Role();
        $userRole->setTitle('ROLE_USER');
        $manager->persist($userRole);

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
        $spots = [];

        /* creation des adresses*/
        for ($i=0; $i < 100; $i++){
            $location = new Location();

            $location->setDepartment($faker->departmentName)
                ->setPostCode(str_replace(' ', '', $faker->postcode))
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

        $location = $locations[mt_rand(0, count($locations) - 1)];

        /* creation des utilisateurs*/
        for ($i=0; $i < 10; $i++) {
            $user = new User();

            $user->setSurname($faker->name)
                ->setFirstname($faker->firstName)
                ->setUsername($faker->userName)
                ->setBirthdayAt($faker->dateTimeBetween($startDate = '-30 years', $endDate = '-3 years'))
                ->setLocation($location)
                ->setEmail($faker->email)
                ->setCreatedAt($faker->dateTime($max = 'now', $timezone = null))
                ->setBiography($faker->text)
                ->setPassword($this->encoder->encodePassword($user, 'password'));
            $manager->persist($user);
            $users[] = $user;

            $location = $locations[mt_rand(0, count($locations) - 1)];
            /* creation des spots*/

            $spot = new Spot();

            $spot->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true))
                ->setDescription($faker->paragraph($nbSentences = 3, $variableNbSentences = true))
                ->setLocation($location)
                ->setType(mt_rand(0, count(Spot::SPOT_TYPE) -1))
                ->setPaying(mt_rand(0, count(Spot::PRICE) -1))
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-1 years', $endDate = '-1 days'))
                ->setAuthor($user);
            $manager->persist($spot);
            $spots[] = $spot;
        }

        // random spotLike
//        for ($i = 0; $i < mt_rand(0,10); $i++){
//            $like = new SpotLike();
//            $like->setSpot($spot)
//                ->setUser($faker->randomElement($users));
//            $manager->persist($like);
//        }

        $manager->flush();
    }
}
