<?php

namespace AdministrationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AdministrationBundle\Entity\User;
use AdministrationBundle\Form\UserType;
use AdministrationBundle\Form\ListUsersType;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @Route("/", name="user")
     *
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $querybuilder = $manager->createQueryBuilder()
            ->select('u')
            ->from('AdministrationBundle:User', 'u');

        $paginator = $this->get('knp_paginator');
        $paginator = $paginator->paginate($querybuilder->getQuery(), $this->getRequest()->query->get('page', 1), 10);

        $formListUsers = $this->createForm(new ListUsersType($paginator));

        if ($request->getMethod() == 'POST') {
            $formListUsers->handleRequest($request);
            if ($formListUsers->isValid()) {
                foreach ($paginator as $user) {
                    $user->setUsername($formListUsers[$user->getId().'username']->getData());
                    $user->setEmail($formListUsers[$user->getId().'email']->getData());
                    $manager->persist($user);
                }
                $manager->flush();

                $this->addFlash('info', 'Data saved.');
            } else {
                $this->addFlash('danger', 'ERROR: '.$formListUsers->getErrorsAsString());
            }
        }

        return array(
            'paginator' => $paginator,
            'formListUsers' => $formListUsers->createView(),
        );
    }
    /**
     * Creates a new User entity.
     *
     * @Route("/new", name="user_create")
     *
     * @Method("POST")
     * @Template("AdministrationBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $newpassword = $form['newpassword']->getData();
            $newpassword2 = $form['newpassword2']->getData();
            if ($newpassword == ''  and $newpassword2 == '') {
                $user->setPlainPassword('thepass');

                $this->addFlash('info', 'User with default password.');
            } else {
                if ($newpassword == $newpassword2) {
                    $user->setPlainPassword($newpassword);

                    $this->addFlash('info', 'Password created.');
                } else {
                    $this->addFlash('danger', 'ERROR: Newpassword is not well repeated.');
                    $user->setPlainPassword('thepass');
                    $this->addFlash('info', 'User with default password.');
                }
            }

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('info', 'Data saved.');

            return $this->redirect($this->generateUrl('user_show', array('id' => $user->getId())));
        }

        return array(
            'entity' => $user,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $user The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $user)
    {
        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('user_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="user_new")
     *
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $user = new User();
        $form   = $this->createCreateForm($user);

        return array(
            'entity' => $user,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="user_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $user = $manager->getRepository('AdministrationBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $user,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     *
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $user = $manager->getRepository('AdministrationBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($user);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $user,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('user_update', array('id' => $user->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="user_update")
     *
     * @Method("PUT")
     * @Template("AdministrationBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $user = $manager->getRepository('AdministrationBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($user);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $newpassword = $editForm['newpassword']->getData();
            $newpassword2 = $editForm['newpassword2']->getData();
            if ($newpassword == $newpassword2 and $newpassword != '') {
                $user->setPlainPassword($newpassword);

                $this->addFlash('info', 'Password changed.');
            } elseif ($newpassword != '') {
                $this->addFlash('danger', 'ERROR: Newpassword is not well repeated.');
            }

            $manager->flush();

            $this->addFlash('info', 'Data saved.');

            return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $user,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="user_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $user = $manager->getRepository('AdministrationBundle:User')->find($id);

            if (!$user) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $manager->remove($user);
            $manager->flush();

            $this->addFlash('info', 'User deleted.');
        }

        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
