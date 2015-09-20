<?php

/**
 * This file is part of The OBMS project: https://github.com/obms/obms
 *
 * Copyright (c) Jaime Niñoles-Manzanera Jimeno.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="administration_home")
     * @Template
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();

        $counters = array();
        $counters['nadministrators'] = $manager->createQuery(
            'SELECT COUNT(a) FROM AdministrationBundle:Administrator a'
            )->getSingleScalarResult();
        $counters['nusers'] = $manager->createQuery(
            'SELECT COUNT(u) FROM AdministrationBundle:User u'
            )->getSingleScalarResult();

        return array(
            'counters' => $counters,
        );
    }

    /**
     * Muestra el formulario de entrada.
     *
     * @Route("/login", name="administration_login")
     * @Template
     *
     * @param Request $request
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
        );
    }
}
