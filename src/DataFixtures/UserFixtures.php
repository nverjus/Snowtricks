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
            'password' => '$argon2i$v=19$m=1024,t=2,p=2$MHY3R2cxa3JIa3FUZkFaRw$E7hqA7d3/pjZB9yo+6XoyyQJlD8kWpbgWbTggcSnCUI',
            'email' => 'admin@admin.com',
            'userPhoto' => $manager->getRepository(UserPhoto::class)->find(1),
          ),
          array(
            'username' => 'user',
            'password' => '$argon2i$v=19$m=1024,t=2,p=2$WHRsUTBxUmVINC9BTzBYMA$SZF2dUDQu7d+czFyEKPmuZA5/XxhJObWqYiasAt4IbU',
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
