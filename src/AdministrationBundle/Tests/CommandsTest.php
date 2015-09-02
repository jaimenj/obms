<?php

namespace BackBundle\Tests;

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
