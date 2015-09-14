<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Business;
use AppBundle\Form\BusinessType;
use AppBundle\Form\ListBusinessesType;

/**
 * Business controller.
 *
 * @Route("/business")
 */
class BusinessController extends Controller
{
    /**
     * Lists all Business entities.
     *
     * @Route("/", name="business")
     *
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $querybuilder = $manager->createQueryBuilder()
            ->select('b, b')
            ->from('AppBundle:Business', 'b')
            ->join('b.users', 'u')
            ->where('u.id = '.$this->getUser()->getId());

        $paginator = $this->get('knp_paginator');
        $paginator = $paginator->paginate($querybuilder->getQuery(), $this->getRequest()->query->get('page', 1), 10);

        $formListBusinesses = $this->createForm(new ListBusinessesType($paginator));

        if ($request->getMethod() == 'POST') {
            $formListBusinesses->handleRequest($request);
            if ($formListBusinesses->isValid()) {
                foreach ($paginator as $business) {
                    $business->setFullname($formListBusinesses[$business->getId().'fullname']->getData());
                    $business->setCifnif($formListBusinesses[$business->getId().'cifnif']->getData());
                    $business->setAddress($formListBusinesses[$business->getId().'address']->getData());
                    $manager->persist($business);
                }
                $manager->flush();

                $this->addFlash('info', 'Data saved.');
            } else {
                $this->addFlash('danger', 'ERROR: '.$formListBusinesses->getErrorsAsString());
            }
        }

        return array(
            'paginator' => $paginator,
            'formListBusinesses' => $formListBusinesses->createView(),
        );
    }
    /**
     * Creates a new Business entity.
     *
     * @Route("/new", name="business_create")
     *
     * @Method("POST")
     * @Template("AppBundle:Business:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $business = new Business();
        $form = $this->createCreateForm($business);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $business->addUser($this->getUser());
            $manager->persist($business);
            $manager->flush();

            $this->addFlash('info', 'Business created.');

            return $this->redirect($this->generateUrl('business_show', array('id' => $business->getId())));
        }

        return array(
            'entity' => $business,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Business entity.
     *
     * @param Business $business The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Business $business)
    {
        $form = $this->createForm(new BusinessType(), $business, array(
            'action' => $this->generateUrl('business_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Business entity.
     *
     * @Route("/new", name="business_new")
     *
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $business = new Business();
        $form   = $this->createCreateForm($business);

        return array(
            'entity' => $business,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Business entity.
     *
     * @Route("/{id}", name="business_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $business = $manager->getRepository('AppBundle:Business')->find($id);

        if (!$business) {
            throw $this->createNotFoundException('Unable to find Business entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $business,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Business entity.
     *
     * @Route("/{id}/edit", name="business_edit")
     *
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $business = $manager->getRepository('AppBundle:Business')->find($id);

        if (!$business) {
            throw $this->createNotFoundException('Unable to find Business entity.');
        }

        $editForm = $this->createEditForm($business);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $business,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Business entity.
     *
     * @param Business $business The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Business $business)
    {
        $form = $this->createForm(new BusinessType(), $business, array(
            'action' => $this->generateUrl('business_update', array('id' => $business->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Business entity.
     *
     * @Route("/{id}", name="business_update")
     *
     * @Method("PUT")
     * @Template("AppBundle:Business:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $business = $manager->getRepository('AppBundle:Business')->find($id);

        if (!$business) {
            throw $this->createNotFoundException('Unable to find Business entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($business);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $manager->flush();

            $this->addFlash('info', 'Data saved.');

            return $this->redirect($this->generateUrl('business_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $business,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Business entity.
     *
     * @Route("/{id}", name="business_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $business = $manager->getRepository('AppBundle:Business')->find($id);

            if (!$business) {
                throw $this->createNotFoundException('Unable to find Business entity.');
            }

            $manager->remove($business);
            $manager->flush();

            $this->addFlash('info', 'Business deleted.');
        }

        return $this->redirect($this->generateUrl('business'));
    }

    /**
     * Creates a form to delete a Business entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('business_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
