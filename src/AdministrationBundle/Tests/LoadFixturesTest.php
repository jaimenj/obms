<?php
namespace BackBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class LoadFixturesTest extends WebTestCase
{

    public function testCargaTodo()
    {
        $classes = array(
            'AdministrationBundle\DataFixtures\ORM\AdministratorFix',
            'AdministrationBundle\DataFixtures\ORM\UserFix',
        );
        $this->loadFixtures($classes);

        $this->assertTrue(true);
    }
}
