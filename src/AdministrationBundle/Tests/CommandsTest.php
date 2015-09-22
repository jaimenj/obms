<?php

/**
 * This file is part of The OBMS project: https://github.com/obms/obms
 *
 * Copyright (c) Jaime Niñoles-Manzanera Jimeno.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdministrationBundle\Tests;

/**
  * Clase que prueba un comando de consola.
  * Utiliza CommandTestCase para crear una Symfony app y tener todo disponible para ejecutar el/los
  * comandos..
  */
 class CommandsTest extends CommandTestCase
 {
     public function testDefaultDoesNotInstall()
     {
         $client = self::createClient();
         $output = $this->runCommand($client, 'sample:data');

         $this->assertContains('Deleting sample data.. loading data.. ok', $output);
     }
 }
