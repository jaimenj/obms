<?php

namespace AdministrationBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdministrationDefaultTest extends WebTestCase
{
    public function setUp()
    {
        exec('php app/console doctrine:fixtures:load --no-interaction --env=test');
        exec('php app/console sample:data --env=test');
    }

    public function testIndex()
    {
        $client = static::createClient(array(), array(
            'HTTPS' => true,
        ));

        $crawler = $client->request('GET', '/administration/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        // testing login
        $crawler = $client->request('GET', '/administration/login');
        $form = $crawler->selectButton('Login')->form();
        $crawler = $client->submit($form, array(
            '_username' => 'administrator',
            '_password' => 'thepass',
        ));
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()
            ->getStatusCode(), $client->getResponse());
    }
}
