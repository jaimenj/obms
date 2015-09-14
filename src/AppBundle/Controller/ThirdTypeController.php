<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ThirdType;
use AppBundle\Form\ThirdTypeType;
use AppBundle\Form\ListThirdTypesType;

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
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $querybuilder = $manager->createQueryBuilder()
            ->select('tt')
            ->from('AppBundle:ThirdType', 'tt')
            ->join('tt.business', 'b')
            ->where('b.id = '.$this->getUser()->getCurrentBusiness()->getId());

        $paginator = $this->get('knp_paginator');
        $paginator = $paginator->paginate($querybuilder->getQuery(), $this->getRequest()->query->get('page', 1), 10);

        $formListThirdTypes = $this->createForm(new ListThirdTypesType($paginator));

        if ($request->getMethod() == 'POST') {
            $formListThirdTypes->handleRequest($request);
            if ($formListThirdTypes->isValid()) {
                foreach ($paginator as $thirdType) {
                    $thirdType->setName($formListThirdTypes[$thirdType->getId().'name']->getData());
                    $manager->persist($thirdType);
                }
                $manager->flush();

                $this->addFlash('info', 'Data saved.');
            } else {
                $this->addFlash('danger', 'ERROR: '.$formListThirdTypes->getErrorsAsString());
            }
        }

        return array(
            'paginator' => $paginator,
            'formListThirdTypes' => $formListThirdTypes->createView(),
        );
    }
    /**
     * Creates a new ThirdType entity.
     *
     * @Route("/new", name="thirdtype_create")
     *
     * @Method("POST")
     * @Template("AppBundle:ThirdType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $thirdType = new ThirdType();
        $form = $this->createCreateForm($thirdType);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $thirdType->setBusiness($this->getUser()->getCurrentBusiness());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($thirdType);
            $manager->flush();

            $this->addFlash('info', 'Third type created.');

            return $this->redirect($this->generateUrl('thirdtype_show', array('id' => $thirdType->getId())));
        }

        return array(
            'entity' => $thirdType,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ThirdType entity.
     *
     * @param ThirdType $thirdType The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ThirdType $thirdType)
    {
        $form = $this->createForm(new ThirdTypeType(), $thirdType, array(
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
        $thirdType = new ThirdType();
        $form   = $this->createCreateForm($thirdType);

        return array(
            'entity' => $thirdType,
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

        $thirdType = $manager->getRepository('AppBundle:ThirdType')->find($id);

        if (!$thirdType) {
            throw $this->createNotFoundException('Unable to find ThirdType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $thirdType,
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

        $thirdType = $manager->getRepository('AppBundle:ThirdType')->find($id);

        if (!$thirdType) {
            throw $this->createNotFoundException('Unable to find ThirdType entity.');
        }

        $editForm = $this->createEditForm($thirdType);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $thirdType,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a ThirdType entity.
     *
     * @param ThirdType $thirdType The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ThirdType $thirdType)
    {
        $form = $this->createForm(new ThirdTypeType(), $thirdType, array(
            'action' => $this->generateUrl('thirdtype_update', array('id' => $thirdType->getId())),
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

        $thirdType = $manager->getRepository('AppBundle:ThirdType')->find($id);

        if (!$thirdType) {
            throw $this->createNotFoundException('Unable to find ThirdType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($thirdType);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $manager->flush();

            $this->addFlash('info', 'Data saved.');

            return $this->redirect($this->generateUrl('thirdtype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $thirdType,
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
            $thirdType = $manager->getRepository('AppBundle:ThirdType')->find($id);

            if (!$thirdType) {
                throw $this->createNotFoundException('Unable to find ThirdType entity.');
            }

            $manager->remove($thirdType);
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
