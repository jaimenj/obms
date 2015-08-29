<?php

namespace AdministrationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AdministrationBundle\Entity\Administrator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * It only fills database with an administration account for the adminsitration panel.
 */
class AdministratorFix extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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

        $administrator = new Administrator();
        $administrator->setUsername('admin');
        $administrator->setEmail('admin@thedomainobms.com');
        $encoder = $factory->getEncoder($administrator);
        $password = $encoder->encodePassword('thepass', $administrator->getSalt());
        $administrator->setPassword($password);

        $manager->persist($administrator);
        $manager->flush();
    }
    public function getOrder()
    {
        return 1;
    }
}
