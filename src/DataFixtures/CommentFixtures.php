<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Comment;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($manager->getRepository(Trick::class)->findAll() as $trick) {
            for ($i = 1 ; $i <= 7 ; $i++) {
                $adminComment = new Comment();
                $adminComment->setUser($manager->getRepository(User::class)->findOneBy(array('username' => 'admin')));
                $adminComment->setContent('Comment '.$i.' from '.$adminComment->getUser()->getUsername());
                $adminComment->setTrick($trick);
                $manager->persist($adminComment);

                $userComment = new Comment();
                $userComment->setUser($manager->getRepository(User::class)->findOneBy(array('username' => 'user')));
                $userComment->setContent('Comment '.$i.' from '.$adminComment->getUser()->getUsername());
                $userComment->setTrick($trick);
                $manager->persist($userComment);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            TrickFixtures::class,
        );
    }
}
