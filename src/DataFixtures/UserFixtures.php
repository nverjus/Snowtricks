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
            'password' => '$argon2i$v=19$m=1024,t=2,p=2$M2FELlUxSllpZzV0ZkgzMw$GU5bHTomP07amK4pzOgArotDvEBExBhNvJuZ9UU0LPM',
            'email' => 'admin@admin.com',
          ),
          array(
            'username' => 'user',
            'password' => '$argon2i$v=19$m=1024,t=2,p=2$MHNoRk5DOTlrdDY1R3VtWg$XkSiswww1kjg90yLu1ZNNAt3H40JQCEhMo6oEkrhCXw',
            'email' => 'user@user.com',
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
