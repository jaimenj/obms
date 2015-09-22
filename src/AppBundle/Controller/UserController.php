<?php

/**
 * This file is part of The OBMS project: https://github.com/obms/obms
 *
 * Copyright (c) Jaime Niñoles-Manzanera Jimeno.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AdministrationBundle\Entity\User;
use AppBundle\Form\UserType;

/**
 * User controller.
 *
 * @Route("/my-profile")
 */
class UserController extends Controller
{
    /**
     * Finds and displays a User entity.
     *
     * @Route("/", name="app_my_profile")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction()
    {
        return array(
            'entity'      => $this->getUser(),
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/edit", name="app_my_profile_edit")
     *
     * @Method("GET")
     * @Template()
     */
    public function editAction()
    {
        $manager = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $editForm = $this->createEditForm($user);

        return array(
            'entity'      => $user,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $user The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $user)
    {
        $form = $this->createForm(new UserType($user), $user, array(
            'action' => $this->generateUrl('my_profile_update'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     * @Route("/", name="my_profile_update")
     *
     * @Method("PUT")
     * @Template("AdministrationBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $editForm = $this->createEditForm($user);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $newpassword = $editForm['newpassword']->getData();
            $newpassword2 = $editForm['newpassword2']->getData();
            if ($newpassword == $newpassword2 and $newpassword != '') {
                $factory = $this->container->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($newpassword, $user->getSalt());
                $this->addFlash('info', $password);
                $user->setPassword($password);

                $this->addFlash('info', 'Password changed.');
            } elseif ($newpassword != '') {
                $this->addFlash('danger', 'ERROR: Newpassword is not well repeated.');
            }

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('info', 'Data saved.');

            return $this->redirect($this->generateUrl('app_my_profile_edit'));
        }

        return array(
            'entity'      => $user,
            'edit_form'   => $editForm->createView(),
        );
    }
}
