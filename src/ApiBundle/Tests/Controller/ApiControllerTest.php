<?php

/**
 * This file is part of The OBMS project: https://github.com/obms/obms
 *
 * Copyright (c) Jaime Niñoles-Manzanera Jimeno.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
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
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW'   => 'thepass',
        ));

        $crawler = $client->request('GET', '/api/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
