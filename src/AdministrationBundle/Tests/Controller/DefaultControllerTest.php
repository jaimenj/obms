<?php

namespace AdministrationBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/administration/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
