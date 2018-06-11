<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;
use App\Entity\UserPhoto;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $usersList = array(
          array(
            'username' => 'admin',
            'password' => 'admin',
            'email' => 'admin@admin.com',
            'userPhoto' => $manager->getRepository(UserPhoto::class)->find(1),
          ),
          array(
            'username' => 'user',
            'password' => 'user',
            'email' => 'user@user.com',
            'userPhoto' => null,
          ),
        );
        foreach ($usersList as $data) {
            $user = new User();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $user->setPassWord($data['password']);
            $user->setIsActive(true);
            $user->setUserPhoto($data['userPhoto']);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserPhotoFixtures::class,
        );
    }
}
