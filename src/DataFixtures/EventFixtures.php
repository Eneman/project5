<?php

namespace App\DataFixtures;

use App\Entity\Stb;
use App\Entity\Trame;
use App\Entity\GNEvent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++)
        {
            $event = new GNEvent();
            $event->setName("GN $i")
                  ->setDate( new \Datetime)
                  ->setDescription("Bla bla bla")
                  ->setLocation("Completement Paumé")
                  ->setLocked(rand(0, 1) ? true : false) ;;

            $manager->persist($event);

            for ($j = 0; $j < 5; $j++)
            {
                $trame = new Trame();
                $trame->setName("Trame $j")
                      ->setOrga("Jean $i$j")
                      ->setDescription("Quelle magnifique trame")
                      ->setMatos("Plein de belles choses")
                      ->setType(\rand(1, 2) == 1 ? "Principale" : "Secondaire")
                      ->setGnevent($event)
                      ->setLocked(rand(0, 1) ? true : false) ;
                
                $manager->persist($trame);

                for ($k = 0; $k < 10; $k++)
                {
                    $scenarToBack = new Stb();
                    $scenarToBack->setDescription("Tres beau ScnarToBack")
                                 ->setName("La quete de machin")
                                 ->setTrame($trame);
                    
                    $manager->persist($scenarToBack);
                }
            }
        }
        $manager->flush();
    }
}
