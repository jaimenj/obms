<?php

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient(array(), array(
            'HTTPS' => true,
            'PHP_AUTH_USER' => 'user1',
            'PHP_AUTH_PW'   => 'thepass',
        ));

        $crawler = $client->request('GET', '/api/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
