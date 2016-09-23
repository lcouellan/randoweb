<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('user');
        $userAdmin->setPlainPassword('123456');
        $userAdmin->setEmail("testUser@user.com");
        $userAdmin->setEnabled(true);
        $manager->persist($userAdmin);
        // On déclenche l'enregistrement de tous les tags
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}