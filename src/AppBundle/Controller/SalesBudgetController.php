<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\SalesBudget;
use AppBundle\Form\SalesBudgetType;

/**
 * SalesBudget controller.
 *
 * @Route("/salesbudget")
 */
class SalesBudgetController extends Controller
{

    /**
     * Lists all SalesBudget entities.
     *
     * @Route("/", name="salesbudget")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:SalesBudget')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SalesBudget entity.
     *
     * @Route("/", name="salesbudget_create")
     * @Method("POST")
     * @Template("AppBundle:SalesBudget:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SalesBudget();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('salesbudget_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a SalesBudget entity.
     *
     * @param SalesBudget $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SalesBudget $entity)
    {
        $form = $this->createForm(new SalesBudgetType(), $entity, array(
            'action' => $this->generateUrl('salesbudget_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SalesBudget entity.
     *
     * @Route("/new", name="salesbudget_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SalesBudget();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SalesBudget entity.
     *
     * @Route("/{id}", name="salesbudget_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:SalesBudget')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalesBudget entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SalesBudget entity.
     *
     * @Route("/{id}/edit", name="salesbudget_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:SalesBudget')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalesBudget entity.');
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
    * Creates a form to edit a SalesBudget entity.
    *
    * @param SalesBudget $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SalesBudget $entity)
    {
        $form = $this->createForm(new SalesBudgetType(), $entity, array(
            'action' => $this->generateUrl('salesbudget_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SalesBudget entity.
     *
     * @Route("/{id}", name="salesbudget_update")
     * @Method("PUT")
     * @Template("AppBundle:SalesBudget:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:SalesBudget')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalesBudget entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('salesbudget_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SalesBudget entity.
     *
     * @Route("/{id}", name="salesbudget_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:SalesBudget')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SalesBudget entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('salesbudget'));
    }

    /**
     * Creates a form to delete a SalesBudget entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('salesbudget_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
