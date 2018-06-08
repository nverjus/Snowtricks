<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\UserPhoto;

class UserPhotoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $photo = new UserPhoto();
        $photo->setAdress('admin.png');
        $manager->persist($photo);

        $manager->flush();
    }
}
