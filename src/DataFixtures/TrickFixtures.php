<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Trick;
use App\Entity\TrickGroup;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $groups = $manager->getRepository(TrickGroup::class)->findAll();
        $list = array(
          array(
            'name' => 'Mute',
            'description' => 'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant',
            'trickGroup' => $groups[0],
          ),
          array(
            'name' => 'Sad',
            'description' => 'Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant',
            'trickGroup' => $groups[0],
          ),
          array(
            'name' => 'Tail Grab',
            'description' => 'Saisie de la partie arrière de la planche, avec la main arrière',
            'trickGroup' => $groups[0],
          ),
          array(
            'name' => 'Nose Grab',
            'description' => 'Saisie de la partie avant de la planche, avec la main avant',
            'trickGroup' => $groups[0],
          ),
          array(
            'name' => 'Japan Air',
            'description' => 'Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside',
            'trickGroup' => $groups[0],
          ),
          array(
            'name' => 'Seat Belt',
            'description' => 'Saisie du carre frontside à l\'arrière avec la main avant',
            'trickGroup' => $groups[0],
          ),
          array(
            'name' => 'Truck Driver',
            'description' => 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)',
            'trickGroup' => $groups[0],
          ),
          array(
            'name' => 'Rodeofront',
            'description' => 'Rotation front avec une impulsion très marquée sur les pointes de pieds',
            'trickGroup' => $groups[1],
          ),
          array(
            'name' => 'Mistyflip',
            'description' => 'C\'est une rotation back mélangée avec un frontflip, effectuée dans un pipe, c\'est un mac-twist, l\'impulsion à lieu sur les pointes de pied',
            'trickGroup' => $groups[1],
          ),
          array(
            'name' => 'Rodeoback',
            'description' => 'C\'est la rotation la plus vue des 3 dernières années, c\'est une rotation back mélangée avec un backflip impulsion sur les talons',
            'trickGroup' => $groups[1],
          ),
          array(
            'name' => '50-50',
            'description' => 'Un slide ou le rider est perpendiculaire à la barre, un pied de chaque cotés',
            'trickGroup' => $groups[2],
          ),
          array(
            'name' => 'Nose slide',
            'description' => 'Variante du 50-50, le pied avant étant en appui sur la barre',
            'trickGroup' => $groups[2],
          ),
          array(
            'name' => 'Tail slide',
            'description' => 'Variante du 50-50, le pied arrière étant en appui sur la barre',
            'trickGroup' => $groups[2],
          ),
          array(
            'name' => 'Nose Press',
            'description' => 'Un trick réalisé parallelement à la barre, le poid du corps sur l\'avant pour soulever le pied arrière',
            'trickGroup' => $groups[2],
          ),
          array(
            'name' => 'Tail Press',
            'description' => 'Un trick réalisé parallelement à la barre, le poid du corps sur l\'arriète pour soulever le pied avant',
            'trickGroup' => $groups[2],
          ),
        );

        foreach ($list as $trickArray) {
            $trick = new Trick();
            $trick->setName($trickArray['name']);
            $trick->setDescription($trickArray['description']);
            $trick->setTrickGroup($trickArray['trickGroup']);
            $manager->persist($trick);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TrickGroupFixtures::class,
        );
    }
}
