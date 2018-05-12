<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\TrickGroup;

class TrickGroupFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $groupsList = ['Grab', 'Flip', 'Slide'];
        foreach ($groupsList as $groupName) {
            $group = new TrickGroup();
            $group->setName($groupName);
            $manager->persist($group);
        }
        $manager->flush();
    }
}
