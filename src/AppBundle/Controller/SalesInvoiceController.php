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
use AppBundle\Entity\SalesInvoice;
use AppBundle\Form\SalesInvoiceType;

/**
 * SalesInvoice controller.
 *
 * @Route("/salesinvoice")
 */
class SalesInvoiceController extends Controller
{

    /**
     * Lists all SalesInvoice entities.
     *
     * @Route("/", name="salesinvoice")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:SalesInvoice')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SalesInvoice entity.
     *
     * @Route("/", name="salesinvoice_create")
     * @Method("POST")
     * @Template("AppBundle:SalesInvoice:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SalesInvoice();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('salesinvoice_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a SalesInvoice entity.
     *
     * @param SalesInvoice $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SalesInvoice $entity)
    {
        $form = $this->createForm(new SalesInvoiceType(), $entity, array(
            'action' => $this->generateUrl('salesinvoice_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SalesInvoice entity.
     *
     * @Route("/new", name="salesinvoice_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SalesInvoice();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SalesInvoice entity.
     *
     * @Route("/{id}", name="salesinvoice_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:SalesInvoice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalesInvoice entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SalesInvoice entity.
     *
     * @Route("/{id}/edit", name="salesinvoice_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:SalesInvoice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalesInvoice entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a SalesInvoice entity.
    *
    * @param SalesInvoice $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SalesInvoice $entity)
    {
        $form = $this->createForm(new SalesInvoiceType(), $entity, array(
            'action' => $this->generateUrl('salesinvoice_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SalesInvoice entity.
     *
     * @Route("/{id}", name="salesinvoice_update")
     * @Method("PUT")
     * @Template("AppBundle:SalesInvoice:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:SalesInvoice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalesInvoice entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('salesinvoice_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SalesInvoice entity.
     *
     * @Route("/{id}", name="salesinvoice_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:SalesInvoice')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SalesInvoice entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('salesinvoice'));
    }

    /**
     * Creates a form to delete a SalesInvoice entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('salesinvoice_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
