<?php

namespace MainBundle\DataFixtures\ORM;

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
        for ($i = 1; $i <= 3; $i ++) {
            $newuser = new User();
            $newuser->setUsername('user'.$i);
            $newuser->setEmail('user'.$i.'@thedomainobms.com');
            $newuser->setEnabled(true);
            $newuser->setPlainPassword('thepass');
            $newuser->addRole('ROLE_USER');

            $manager->persist($newuser);
        }

        $manager->flush();
    }
    public function getOrder()
    {
        return 3;
    }
}
