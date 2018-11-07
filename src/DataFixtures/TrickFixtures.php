<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 10; $i++)
        {
           $trick = new Trick();
           $trick->setName("Nom de la figure n°$i")
                 ->setDescription("Description de la figure")
                 ->setCategory("Flip")
                 ->setCreatedAt(new \DateTime());

           $manager->persist($trick);
        }

        $manager->flush();
    }
}
