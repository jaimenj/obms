<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="app_home")
     * @Template
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();
        
        $counters = array();
        $counters['nthirds'] = $manager->createQuery(
            'SELECT COUNT(t) FROM AppBundle:Third t'
            )->getSingleScalarResult();
        $counters['nthirdtypes'] = $manager->createQuery(
            'SELECT COUNT(tt) FROM AppBundle:ThirdType tt'
            )->getSingleScalarResult();

        return array(
            'counters' => $counters,
        );
    }

    /**
     * Muestra el formulario de entrada.
     *
     * @Route("/login", name="app_login")
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
