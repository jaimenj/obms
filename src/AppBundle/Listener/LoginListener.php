<?php

/**
 * This file is part of The OBMS project: https://github.com/obms/obms
 *
 * Copyright (c) Jaime Niñoles-Manzanera Jimeno.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\DependencyInjection\Container;

class LoginListener
{
    private $securityContext;

    private $manager;

    private $container;

    public function __construct(SecurityContext $securityContext, Doctrine $doctrine, Container $container)
    {
        $this->securityContext = $securityContext;
        $this->manager = $doctrine->getManager();
        $this->container = $container;
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
    }

    public function onAuthenticationSuccess(InteractiveLoginEvent $event)
    {
        $session = $this->container->get('session');

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            // user has just logged in
        }

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // user has logged in using remember_me cookie
        }

        // Saving the session id database
        $user = $event->getAuthenticationToken()->getUser();
        if (get_class($user) == 'AdministrationBundle\Entity\User') {
            $user->setSessionId($this->container->get('session')->getId());
            $this->manager->persist($user);
            $this->manager->flush();
        }
    }
}
