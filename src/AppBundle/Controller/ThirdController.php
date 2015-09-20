<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Third;
use AppBundle\Form\ThirdType;
use AppBundle\Form\ListThirdsType;

/**
 * Third controller.
 *
 * @Route("/third")
 */
class ThirdController extends Controller
{
    /**
     * Lists all Third entities.
     *
     * @Route("/list/{typeId}", name="third")
     *
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request, $typeId = null)
    {
        $manager = $this->getDoctrine()->getManager();
        $thirdType = null;

        $querybuilder = $manager->createQueryBuilder()
            ->select('t, tt')
            ->from('AppBundle:Third', 't')
            ->leftJoin('t.thirdType', 'tt')
            ->join('t.business', 'b')
            ->where('b.id = '.$this->getUser()->getCurrentBusiness()->getId());

        if ($typeId) {
            $thirdType = $manager->getRepository('AppBundle:Thirdtype')->find($typeId);
            $querybuilder->andWhere('tt.id = '.$typeId);
        }

        $paginator = $this->get('knp_paginator');
        $paginator = $paginator->paginate($querybuilder->getQuery(), $this->getRequest()->query->get('page', 1), 10);

        $formListThirds = $this->createForm(new ListThirdsType($paginator, $this->getUser()));

        if ($request->getMethod() == 'POST') {
            $formListThirds->handleRequest($request);
            if ($formListThirds->isValid()) {
                foreach ($paginator as $third) {
                    $third->setFullname($formListThirds[$third->getId().'fullname']->getData());
                    $third->setEmail($formListThirds[$third->getId().'email']->getData());
                    $third->setThirdType($formListThirds[$third->getId().'thirdType']->getData());
                    $manager->persist($third);
                }
                $manager->flush();

                $this->addFlash('info', 'Data saved.');
            } else {
                $this->addFlash('danger', 'ERROR: '.$formListThirds->getErrorsAsString());
            }
        }

        return array(
            'paginator' => $paginator,
            'formListThirds' => $formListThirds->createView(),
            'thirdType' => $thirdType,
        );
    }

    /**
     * Creates a new Third entity.
     *
     * @Route("/new", name="third_create")
     *
     * @Method("POST")
     * @Template("AppBundle:Third:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $third = new Third();
        $form = $this->createCreateForm($third);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $third->setBusiness($this->getUser()->getCurrentBusiness());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($third);
            $manager->flush();

            $this->addFlash('info', 'Third created.');

            return $this->redirect($this->generateUrl('third_show', array('id' => $third->getId())));
        }

        return array(
            'entity' => $third,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Third entity.
     *
     * @param Third $third The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Third $third)
    {
        $form = $this->createForm(new ThirdType($this->getUser()), $third, array(
            'action' => $this->generateUrl('third_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Third entity.
     *
     * @Route("/new", name="third_new")
     *
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $third = new Third();
        $form   = $this->createCreateForm($third);

        return array(
            'entity' => $third,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Third entity.
     *
     * @Route("/{id}", name="third_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $third = $manager->getRepository('AppBundle:Third')->find($id);

        if (!$third) {
            throw $this->createNotFoundException('Unable to find Third entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $third,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Third entity.
     *
     * @Route("/{id}/edit", name="third_edit")
     *
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $third = $manager->getRepository('AppBundle:Third')->find($id);

        if (!$third) {
            throw $this->createNotFoundException('Unable to find Third entity.');
        }

        $editForm = $this->createEditForm($third);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $third,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Third entity.
     *
     * @param Third $third The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Third $third)
    {
        $form = $this->createForm(new ThirdType($this->getUser()), $third, array(
            'action' => $this->generateUrl('third_update', array('id' => $third->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Third entity.
     *
     * @Route("/{id}", name="third_update")
     *
     * @Method("PUT")
     * @Template("AppBundle:Third:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $third = $manager->getRepository('AppBundle:Third')->find($id);

        if (!$third) {
            throw $this->createNotFoundException('Unable to find Third entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($third);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $manager->flush();

            $this->addFlash('info', 'Data saved.');

            return $this->redirect($this->generateUrl('third_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $third,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Third entity.
     *
     * @Route("/{id}", name="third_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $third = $manager->getRepository('AppBundle:Third')->find($id);

            if (!$third) {
                throw $this->createNotFoundException('Unable to find Third entity.');
            }

            $manager->remove($third);
            $manager->flush();

            $this->addFlash('info', 'Third removed.');
        }

        return $this->redirect($this->generateUrl('third'));
    }

    /**
     * Creates a form to delete a Third entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('third_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
