<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Worker;
use AppBundle\Form\WorkerType;
use AppBundle\Form\ListWorkersType;

/**
 * Worker controller.
 *
 * @Route("/worker")
 */
class WorkerController extends Controller
{
    /**
     * Lists all Worker entities.
     *
     * @Route("/", name="worker")
     *
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $querybuilder = $manager->createQueryBuilder()
            ->select('w')
            ->from('AppBundle:Worker', 'w')
            ->join('w.business', 'b')
            ->where('b.id = '.$this->getUser()->getCurrentBusiness()->getId());

        $paginator = $this->get('knp_paginator');
        $paginator = $paginator->paginate($querybuilder->getQuery(), $this->getRequest()->query->get('page', 1), 10);

        $formListWorkers = $this->createForm(new ListWorkersType($paginator));

        if ($request->getMethod() == 'POST') {
            $formListWorkers->handleRequest($request);
            if ($formListWorkers->isValid()) {
                foreach ($paginator as $worker) {
                    $worker->setFullname($formListWorkers[$worker->getId().'fullname']->getData());
                    $worker->setTelephone($formListWorkers[$worker->getId().'telephone']->getData());
                    $worker->setEmail($formListWorkers[$worker->getId().'email']->getData());
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
            'formListWorkers' => $formListWorkers->createView(),
        );
    }

    /**
     * Creates a new Worker entity.
     *
     * @Route("/new", name="worker_create")
     *
     * @Method("POST")
     * @Template("AppBundle:Worker:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $worker = new Worker();
        $form = $this->createCreateForm($worker);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $worker->setBusiness($this->getUser()->getCurrentBusiness());
            $manager->persist($worker);
            $manager->flush();

            $this->addFlash('info', 'Worker created.');

            return $this->redirect($this->generateUrl('worker_show', array('id' => $worker->getId())));
        }

        return array(
            'entity' => $worker,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Worker entity.
     *
     * @param Worker $worker The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Worker $worker)
    {
        $form = $this->createForm(new WorkerType(), $worker, array(
            'action' => $this->generateUrl('worker_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Worker entity.
     *
     * @Route("/new", name="worker_new")
     *
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $worker = new Worker();
        $form   = $this->createCreateForm($worker);

        return array(
            'entity' => $worker,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Worker entity.
     *
     * @Route("/{id}", name="worker_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $worker = $manager->getRepository('AppBundle:Worker')->find($id);

        if (!$worker) {
            throw $this->createNotFoundException('Unable to find Worker entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $worker,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Worker entity.
     *
     * @Route("/{id}/edit", name="worker_edit")
     *
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $worker = $manager->getRepository('AppBundle:Worker')->find($id);

        if (!$worker) {
            throw $this->createNotFoundException('Unable to find Worker entity.');
        }

        $editForm = $this->createEditForm($worker);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $worker,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Worker entity.
     *
     * @param Worker $worker The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Worker $worker)
    {
        $form = $this->createForm(new WorkerType(), $worker, array(
            'action' => $this->generateUrl('worker_update', array('id' => $worker->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Worker entity.
     *
     * @Route("/{id}", name="worker_update")
     *
     * @Method("PUT")
     * @Template("AppBundle:Worker:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $worker = $manager->getRepository('AppBundle:Worker')->find($id);

        if (!$worker) {
            throw $this->createNotFoundException('Unable to find Worker entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($worker);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $manager->flush();

            $this->addFlash('info', 'Data saved.');

            return $this->redirect($this->generateUrl('worker_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $worker,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Worker entity.
     *
     * @Route("/{id}", name="worker_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $worker = $manager->getRepository('AppBundle:Worker')->find($id);

            if (!$worker) {
                throw $this->createNotFoundException('Unable to find Worker entity.');
            }

            $manager->remove($worker);
            $manager->flush();

            $this->addFlash('info', 'Worker deleted.');
        }

        return $this->redirect($this->generateUrl('worker'));
    }

    /**
     * Creates a form to delete a Worker entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('worker_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
