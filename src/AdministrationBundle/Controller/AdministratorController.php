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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AdministrationBundle\Entity\Administrator;
use AdministrationBundle\Form\AdministratorType;
use AdministrationBundle\Form\ListAdministratorsType;

/**
 * Administrator controller.
 *
 * @Route("/administrator")
 */
class AdministratorController extends Controller
{
    /**
     * Lists all Administrator entities.
     *
     * @Route("/", name="administrator")
     *
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $querybuilder = $manager->createQueryBuilder()
            ->select('a')
            ->from('AdministrationBundle:Administrator', 'a');

        $paginator = $this->get('knp_paginator');
        $paginator = $paginator->paginate($querybuilder->getQuery(), $this->getRequest()->query->get('page', 1), 10);

        $formListAdministrators = $this->createForm(new ListAdministratorsType($paginator));

        if ($request->getMethod() == 'POST') {
            $formListAdministrators->handleRequest($request);
            if ($formListAdministrators->isValid()) {
                foreach ($paginator as $administrator) {
                    $administrator->setUsername($formListAdministrators[$administrator->getId().'username']->getData());
                    $administrator->setEmail($formListAdministrators[$administrator->getId().'email']->getData());
                    $manager->persist($administrator);
                }
                $manager->flush();

                $this->addFlash('info', 'Data saved.');
            } else {
                $this->addFlash('danger', 'ERROR: '.$formListAdministrators->getErrorsAsString());
            }
        }

        return array(
            'paginator' => $paginator,
            'formListAdministrators' => $formListAdministrators->createView(),
        );
    }

    /**
     * Creates a new Administrator entity.
     *
     * @Route("/new", name="administrator_create")
     *
     * @Method("POST")
     * @Template("AdministrationBundle:Administrator:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $administrator = new Administrator();
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($administrator);
        $form = $this->createCreateForm($administrator);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $newpassword = $form['newpassword']->getData();
            $newpassword2 = $form['newpassword2']->getData();
            if ($newpassword == ''  and $newpassword2 == '') {
                $password = $encoder->encodePassword('thepass', $administrator->getSalt());
                $administrator->setPassword($password);

                $this->addFlash('info', 'Administrator with default password.');
            } else {
                if ($newpassword == $newpassword2) {
                    $password = $encoder->encodePassword('thepass', $administrator->getSalt());
                    $administrator->setPassword($password);

                    $this->addFlash('info', 'Password created.');
                } else {
                    $this->addFlash('danger', 'ERROR: Newpassword is not well repeated.');
                    $administrator->setPlainPassword('thepass');
                    $this->addFlash('info', 'Administrator with default password.');
                }
            }

            $manager->persist($administrator);
            $manager->flush();

            $this->addFlash('info', 'Administrator created.');

            return $this->redirect($this->generateUrl('administrator_show', array('id' => $administrator->getId())));
        }

        return array(
            'entity' => $administrator,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Administrator entity.
     *
     * @param Administrator $administrator The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Administrator $administrator)
    {
        $form = $this->createForm(new AdministratorType(), $administrator, array(
            'action' => $this->generateUrl('administrator_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Administrator entity.
     *
     * @Route("/new", name="administrator_new")
     *
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $administrator = new Administrator();
        $form   = $this->createCreateForm($administrator);

        return array(
            'entity' => $administrator,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Administrator entity.
     *
     * @Route("/{id}", name="administrator_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $administrator = $manager->getRepository('AdministrationBundle:Administrator')->find($id);

        if (!$administrator) {
            throw $this->createNotFoundException('Unable to find Administrator entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $administrator,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Administrator entity.
     *
     * @Route("/{id}/edit", name="administrator_edit")
     *
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $administrator = $manager->getRepository('AdministrationBundle:Administrator')->find($id);

        if (!$administrator) {
            throw $this->createNotFoundException('Unable to find Administrator entity.');
        }

        $editForm = $this->createEditForm($administrator);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $administrator,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Administrator entity.
     *
     * @param Administrator $administrator The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Administrator $administrator)
    {
        $form = $this->createForm(new AdministratorType(), $administrator, array(
            'action' => $this->generateUrl('administrator_update', array('id' => $administrator->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Administrator entity.
     *
     * @Route("/{id}", name="administrator_update")
     *
     * @Method("PUT")
     * @Template("AdministrationBundle:Administrator:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $administrator = $manager->getRepository('AdministrationBundle:Administrator')->find($id);

        if (!$administrator) {
            throw $this->createNotFoundException('Unable to find Administrator entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($administrator);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $newpassword = $editForm['newpassword']->getData();
            $newpassword2 = $editForm['newpassword2']->getData();
            if ($newpassword == $newpassword2 and $newpassword != '') {
                $factory = $this->container->get('security.encoder_factory');
                $encoder = $factory->getEncoder($administrator);
                $password = $encoder->encodePassword($newpassword, $administrator->getSalt());
                $administrator->setPassword($password);

                $this->addFlash('info', 'Password changed.');
            } elseif ($newpassword != '') {
                $this->addFlash('danger', 'ERROR: Newpassword is not well repeated.');
            }

            $manager->flush();

            $this->addFlash('info', 'Data saved.');

            return $this->redirect($this->generateUrl('administrator_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $administrator,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Administrator entity.
     *
     * @Route("/{id}", name="administrator_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $administrator = $manager->getRepository('AdministrationBundle:Administrator')->find($id);

            if (!$administrator) {
                throw $this->createNotFoundException('Unable to find Administrator entity.');
            }

            $manager->remove($administrator);
            $manager->flush();

            $this->addFlash('info', 'Administrator removed.');
        }

        return $this->redirect($this->generateUrl('administrator'));
    }

    /**
     * Creates a form to delete a Administrator entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administrator_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
