<?php

namespace AdministrationBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdministrationControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient(array(), array(
            'HTTPS' => true,
        ));

        $crawler = $client->request('GET', '/administration/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
