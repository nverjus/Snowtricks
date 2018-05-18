<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Trick;
use App\Entity\Video;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $adresses = ['<iframe width="560" height="315" src="https://www.youtube.com/embed/CA5bURVJ5zk" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>', '<iframe width="560" height="315" src="https://www.youtube.com/embed/UNItNopAeDU" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'];

        $video1 = new Video();
        $video1->setIframe($adresses[0]);
        $video1->setTrick($manager->getRepository(Trick::class)->findOneBy(['name' => 'Mute']));
        $manager->persist($video1);

        $video2 = new Video();
        $video2->setIframe($adresses[1]);
        $video2->setTrick($manager->getRepository(Trick::class)->findOneBy(['name' => 'Sad']));
        $manager->persist($video2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TrickFixtures::class,
        );
    }
}
