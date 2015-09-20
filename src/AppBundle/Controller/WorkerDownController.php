<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\WorkerDown;
use AppBundle\Form\WorkerDownType;
use AppBundle\Form\ListWorkerDownsType;

/**
 * WorkerDown controller.
 *
 * @Route("/workerdown")
 */
class WorkerDownController extends Controller
{
    /**
     * Lists all WorkerDown entities.
     *
     * @Route("/", name="workerdown")
     *
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $querybuilder = $manager->createQueryBuilder()
            ->select('wd')
            ->from('AppBundle:WorkerDown', 'wd')
            ->join('wd.worker', 'w')
            ->join('w.business', 'b')
            ->where('b.id = '.$this->getUser()->getCurrentBusiness()->getId());

        $paginator = $this->get('knp_paginator');
        $paginator = $paginator->paginate($querybuilder->getQuery(), $this->getRequest()->query->get('page', 1), 10);

        $formListWorkers = $this->createForm(new ListWorkerDownsType($paginator, $this->getUser()));

        if ($request->getMethod() == 'POST') {
            $formListWorkers->handleRequest($request);
            if ($formListWorkers->isValid()) {
                foreach ($paginator as $worker) {
                    $worker->setFullname($formListWorkers[$worker->getId().'initdate']->getData());
                    $worker->setTelephone($formListWorkers[$worker->getId().'finishdate']->getData());
                    $worker->setEmail($formListWorkers[$worker->getId().'worker']->getData());
                    $manager->persist($worker);
                }
                $manager->flush();

                $this->addFlash('info', 'Data saved.');
            } else {
                $this->addFlash('danger', 'ERROR: '.$formListWorkers->getErrorsAsString());
            }
        }

        return array(
            'paginator' => $paginator,
            'formListWorkerDowns' => $formListWorkers->createView(),
        );
    }
    /**
     * Creates a new WorkerDown entity.
     *
     * @Route("/new", name="workerdown_create")
     *
     * @Method("POST")
     * @Template("AppBundle:WorkerDown:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $workerDown = new WorkerDown();
        $form = $this->createCreateForm($workerDown);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($workerDown);
            $manager->flush();

            $this->addFlash('info', 'Worker down created.');

            return $this->redirect($this->generateUrl('workerdown_show', array('id' => $workerDown->getId())));
        }

        return array(
            'entity' => $workerDown,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a WorkerDown entity.
     *
     * @param WorkerDown $workerDown The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(WorkerDown $workerDown)
    {
        $form = $this->createForm(new WorkerDownType(), $workerDown, array(
            'action' => $this->generateUrl('workerdown_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new WorkerDown entity.
     *
     * @Route("/new", name="workerdown_new")
     *
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $workerDown = new WorkerDown();
        $form   = $this->createCreateForm($workerDown);

        return array(
            'entity' => $workerDown,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a WorkerDown entity.
     *
     * @Route("/{id}", name="workerdown_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $workerDown = $manager->getRepository('AppBundle:WorkerDown')->find($id);

        if (!$workerDown) {
            throw $this->createNotFoundException('Unable to find WorkerDown entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $workerDown,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing WorkerDown entity.
     *
     * @Route("/{id}/edit", name="workerdown_edit")
     *
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $workerDown = $manager->getRepository('AppBundle:WorkerDown')->find($id);

        if (!$workerDown) {
            throw $this->createNotFoundException('Unable to find WorkerDown entity.');
        }

        $editForm = $this->createEditForm($workerDown);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $workerDown,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a WorkerDown entity.
     *
     * @param WorkerDown $workerDown The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(WorkerDown $workerDown)
    {
        $form = $this->createForm(new WorkerDownType(), $workerDown, array(
            'action' => $this->generateUrl('workerdown_update', array('id' => $workerDown->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing WorkerDown entity.
     *
     * @Route("/{id}", name="workerdown_update")
     *
     * @Method("PUT")
     * @Template("AppBundle:WorkerDown:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $workerDown = $manager->getRepository('AppBundle:WorkerDown')->find($id);

        if (!$workerDown) {
            throw $this->createNotFoundException('Unable to find WorkerDown entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($workerDown);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $manager->flush();

            $this->addFlash('info', 'Data saved.');

            return $this->redirect($this->generateUrl('workerdown_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $workerDown,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a WorkerDown entity.
     *
     * @Route("/{id}", name="workerdown_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $workerDown = $manager->getRepository('AppBundle:WorkerDown')->find($id);

            if (!$workerDown) {
                throw $this->createNotFoundException('Unable to find WorkerDown entity.');
            }

            $manager->remove($workerDown);
            $manager->flush();

            $this->addFlash('info', 'Worker down deleted.');
        }

        return $this->redirect($this->generateUrl('workerdown'));
    }

    /**
     * Creates a form to delete a WorkerDown entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('workerdown_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
