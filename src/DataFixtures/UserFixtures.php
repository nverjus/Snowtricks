<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\ENtity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $usersList = array(
          array(
            'username' => 'admin',
            'password' => '$argon2i$v=19$m=1024,t=2,p=2$MHY3R2cxa3JIa3FUZkFaRw$E7hqA7d3/pjZB9yo+6XoyyQJlD8kWpbgWbTggcSnCUI',
            'email' => 'admin@admin.com',
            'isActive' => true,
          ),
          array(
            'username' => 'user',
            'password' => '$argon2i$v=19$m=1024,t=2,p=2$WHRsUTBxUmVINC9BTzBYMA$SZF2dUDQu7d+czFyEKPmuZA5/XxhJObWqYiasAt4IbU',
            'email' => 'user@user.com',
            'isActive' => true,
          ),
        );
        foreach ($usersList as $data) {
            $user = new User();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $user->setPassWord($data['password']);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
