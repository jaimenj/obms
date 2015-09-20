<?php

/**
 * This file is part of The OBMS project: https://github.com/obms/obms
 *
 * Copyright (c) Jaime Niñoles-Manzanera Jimeno.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
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
