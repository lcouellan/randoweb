<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Randonnee;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadRandonneeData extends AbstractFixture implements ContainerAwareInterface,FixtureInterface, OrderedFixtureInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    public function load(ObjectManager $manager)
    {
        $data = [
            ['Reserve du coteau Mesnil Soleil',48.927219,-0.148719,3.7,'facile',70,'test1.jpg',' Le point de départ est le terrain d\'aviation de Falaise-Monts d\'Eraines (Calvados 14) \r\nSentier pédagogique réserve naturelle du coteau du Mesnil Soleil à Versainville. \r\nCe petit parcours est très intéressant par la diversité des espèces végétales . \r\nVous pourrez y rencontrer les chèvres et les vaches brouteuses. \r\nBonne randonnée ', '1.gpx'],
            ['Carentan - Sur les traces des paras', 49.301, -1.2412, 12.1, 'difficile', 150, 'test2.jpg', 'Boucle permettant de visiter le port, le pont de la barquette, le chateau Bellenau, l\'église de Carentan...\r\nFacile, durée environ 2h30 \r\nBonne randonnée ', '2.gpx'],
            ['Deauville et ses hauteurs', 49.355171, 0.057726, 7.6, 'moyen', 120, 'test3.jpg', 'Une partie de la plage à marée basse .\r\nMontée jusqu\' au Mont Canisy pour le point de vue.\r\nRetour par la plage.\r\nBonne randonnée ', '3.gpx'],
            ['Caen - Bord de l\'Orne', 49.173363, -0.362593, 5.9, 'moyen', 90, 'test4.jpg', 'Balade au bord de l\' Orne et retour par la mairie. \r\nPassage par l\' hippodrome .\r\nIdéal en marche nordique . \r\nBonne randonnée ', '4.gpx'],
        ];

        foreach ($data as $line) {
            $randonnee = new Randonnee();
            $randonnee->setName($line[0]);
            $randonnee->setLatitude($line[1]);
            $randonnee->setLongitude($line[2]);
            $randonnee->setDistance($line[3]);
            $randonnee->setDifficulty($line[4]);
            $randonnee->setTime($line[5]);
            $randonnee->setImage($line[6]);
            $randonnee->setDescription($line[7]);
            $randonnee->setTrace($line[8]);

            $users = $this->container->get('fos_user.user_manager')->findUsers();
            $randonnee->setAuthor($users[0]->getId());
            $manager->persist($randonnee);
        }

        // On déclenche l'enregistrement de tous les tags
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}