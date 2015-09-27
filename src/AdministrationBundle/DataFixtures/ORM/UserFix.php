<?php

/**
 * This file is part of The OBMS project: https://github.com/obms/obms
 *
 * Copyright (c) Jaime Niñoles-Manzanera Jimeno.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdministrationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AdministrationBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * It only fills database with example users.
 */
class UserFix extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $factory = $this->container->get('security.encoder_factory');

        $newuser = new User();
        $newuser->setUsername('user');
        $newuser->setEmail('user@thedomainobms.com');
        $encoder = $factory->getEncoder($newuser);
        $password = $encoder->encodePassword('thepass', $newuser->getSalt());
        $newuser->setPassword($password);
        $newuser->setIsEnabled(true);
        $newuser->setThirdsEnabled(true);
        $newuser->setHhrrEnabled(true);
        $newuser->setShoppingEnabled(true);
        $newuser->setStorageEnabled(true);
        $newuser->setSalesEnabled(true);
        $newuser->setAccountingEnabled(true);
        $newuser->setProductionEnabled(true);
        $newuser->setLogisticsEnabled(true);
        $newuser->setPlanificationEnabled(true);
        $newuser->setProcessControlEnabled(true);
        $newuser->setDocumentsEnabled(true);
        $newuser->setIntelligenceEnabled(true);

        $manager->persist($newuser);
        $manager->flush();
    }
    public function getOrder()
    {
        return 2;
    }
}
