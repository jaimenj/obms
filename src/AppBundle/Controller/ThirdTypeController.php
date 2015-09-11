<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ThirdType;
use AppBundle\Form\ThirdTypeType;

/**
 * ThirdType controller.
 *
 * @Route("/thirdtype")
 */
class ThirdTypeController extends Controller
{
    /**
     * Lists all ThirdType entities.
     *
     * @Route("/", name="thirdtype")
     *
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();

        $querybuilder = $manager->createQueryBuilder()
            ->select('tt')
            ->from('AppBundle:ThirdType', 'tt');

        $paginator = $this->get('knp_paginator');
        $paginator = $paginator->paginate($querybuilder->getQuery(), $this->getRequest()->query->get('page', 1), 10);

        return array(
            'paginator' => $paginator,
        );
    }
    /**
     * Creates a new ThirdType entity.
     *
     * @Route("/", name="thirdtype_create")
     *
     * @Method("POST")
     * @Template("AppBundle:ThirdType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ThirdType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($entity);
            $manager->flush();

            $this->addFlash('info', 'Third type created.');

            return $this->redirect($this->generateUrl('thirdtype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ThirdType entity.
     *
     * @param ThirdType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ThirdType $entity)
    {
        $form = $this->createForm(new ThirdTypeType(), $entity, array(
            'action' => $this->generateUrl('thirdtype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ThirdType entity.
     *
     * @Route("/new", name="thirdtype_new")
     *
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ThirdType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ThirdType entity.
     *
     * @Route("/{id}", name="thirdtype_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $entity = $manager->getRepository('AppBundle:ThirdType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ThirdType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ThirdType entity.
     *
     * @Route("/{id}/edit", name="thirdtype_edit")
     *
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $entity = $manager->getRepository('AppBundle:ThirdType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ThirdType entity.');
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
     * Creates a form to edit a ThirdType entity.
     *
     * @param ThirdType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ThirdType $entity)
    {
        $form = $this->createForm(new ThirdTypeType(), $entity, array(
            'action' => $this->generateUrl('thirdtype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ThirdType entity.
     *
     * @Route("/{id}", name="thirdtype_update")
     *
     * @Method("PUT")
     * @Template("AppBundle:ThirdType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $entity = $manager->getRepository('AppBundle:ThirdType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ThirdType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $manager->flush();

            $this->addFlash('info', 'Data saved.');

            return $this->redirect($this->generateUrl('thirdtype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ThirdType entity.
     *
     * @Route("/{id}", name="thirdtype_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $entity = $manager->getRepository('AppBundle:ThirdType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ThirdType entity.');
            }

            $manager->remove($entity);
            $manager->flush();

            $this->addFlash('info', 'Third type removed.');
        }

        return $this->redirect($this->generateUrl('thirdtype'));
    }

    /**
     * Creates a form to delete a ThirdType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('thirdtype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
