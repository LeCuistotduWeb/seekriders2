<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Spot;
use App\Entity\SpotLike;
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
        $adminUser = new User();
        $adminUser->setFirstname('gaetan')
            ->setSurname('boyron')
            ->setUsername('admin')
            ->setEmail('gaetan.boyron@gmail.com')
            ->setPassword($this->encoder->encodePassword($adminUser, 'password'))
            ->setLevel(2)
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($adminUser);
        $manager->flush();
    }
}
