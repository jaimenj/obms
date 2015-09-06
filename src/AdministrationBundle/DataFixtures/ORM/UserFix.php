<?php

namespace AdministrationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AdministrationBundle\Entity\User;

/**
 * It only fills database with example users.
 */
class UserFix extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $newuser = new User();
        $newuser->setUsername('user');
        $newuser->setEmail('user@thedomainobms.com');
        $newuser->setEnabled(true);
        $newuser->setPlainPassword('thepass');
        $newuser->addRole('ROLE_USER');

        $manager->persist($newuser);

        $manager->flush();
    }
    public function getOrder()
    {
        return 3;
    }
}
