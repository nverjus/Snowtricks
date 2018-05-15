<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;
use App\Entity\UserPhoto;

class UserPhotoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $admin = $manager->getRepository(User::class)->findOneBy(array('username' => 'admin'));

        $photo = new UserPhoto();
        $photo->setAlt('Admin');
        $photo->setAdress('admin.png');
        $photo->setUser($admin);
        $manager->persist($photo);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
