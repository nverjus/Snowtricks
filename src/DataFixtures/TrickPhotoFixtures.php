<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Trick;
use App\Entity\TrickPhoto;

class TrickPhotoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tricks = $manager->getRepository(Trick::class)->findAll();
        $grabs = ['grab1.jpg', 'grab2.jpg'];
        $flips = ['flip1.jpg', 'flip2.jpg', 'flip3.jpg'];

        foreach ($tricks as $trick) {
            if ($trick->getTrickGroup()->getName() == 'Grab') {
                foreach ($grabs as $grab) {
                    $photo = new TrickPhoto();
                    $photo->setAdress($grab);
                    $photo->setAlt('Grab');
                    $photo->setTrick($trick);
                    $manager->persist($photo);
                    if ($grab == 'grab1.jpg') {
                        $trick->setFrontPhoto($photo);
                    }
                }
            } elseif ($trick->getTrickGroup()->getName() == 'Flip') {
                foreach ($flips as $flip) {
                    $photo = new TrickPhoto();
                    $photo->setAdress($flip);
                    $photo->setAlt('Flip');
                    $photo->setTrick($trick);
                    $manager->persist($photo);
                    if ($flip == 'flip1.jpg') {
                        $trick->setFrontPhoto($photo);
                    }
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TrickFixtures::class,
        );
    }
}
