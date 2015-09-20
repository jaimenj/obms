<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\WorkerPayroll;
use AppBundle\Form\WorkerPayrollType;
use AppBundle\Form\ListWorkerPayrollsType;

/**
 * WorkerPayroll controller.
 *
 * @Route("/workerpayroll")
 */
class WorkerPayrollController extends Controller
{
    /**
     * Lists all WorkerPayroll entities.
     *
     * @Route("/", name="workerpayroll")
     *
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $querybuilder = $manager->createQueryBuilder()
            ->select('wp')
            ->from('AppBundle:WorkerPayroll', 'wp')
            ->join('wp.worker', 'w')
            ->join('w.business', 'b')
            ->where('b.id = '.$this->getUser()->getCurrentBusiness()->getId());

        $paginator = $this->get('knp_paginator');
        $paginator = $paginator->paginate($querybuilder->getQuery(), $this->getRequest()->query->get('page', 1), 10);

        $formListWorkerPayrolls = $this->createForm(new ListWorkerPayrollsType($paginator));

        if ($request->getMethod() == 'POST') {
            $formListWorkerPayrolls->handleRequest($request);
            if ($formListWorkerPayrolls->isValid()) {
                foreach ($paginator as $workerPayrroll) {
                    $workerPayrroll->setYear($formListWorkerPayrolls[$workerPayrroll->getId().'year']->getData());
                    $workerPayrroll->setMonth($formListWorkerPayrolls[$workerPayrroll->getId().'month']->getData());
                    $workerPayrroll->setAmount($formListWorkerPayrolls[$workerPayrroll->getId().'amount']->getData());
                    $workerPayrroll->setWorker($formListWorkerPayrolls[$workerPayrroll->getId().'worker']->getData());
                    $manager->persist($workerPayrroll);
                }
                $manager->flush();

                $this->addFlash('info', 'Data saved.');
            } else {
                $this->addFlash('danger', 'ERROR: '.$formListWorkerPayrolls->getErrorsAsString());
            }
        }

        return array(
            'paginator' => $paginator,
            'formListWorkerPayrolls' => $formListWorkerPayrolls->createView(),
        );
    }

    /**
     * Creates a new WorkerPayroll entity.
     *
     * @Route("/new", name="workerpayroll_create")
     *
     * @Method("POST")
     * @Template("AppBundle:WorkerPayroll:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $workerPayroll = new WorkerPayroll();
        $form = $this->createCreateForm($workerPayroll);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($workerPayroll);
            $manager->flush();

            $this->addFlash('info', 'Worker payroll created.');

            return $this->redirect($this->generateUrl('workerpayroll_show', array('id' => $workerPayroll->getId())));
        }

        return array(
            'entity' => $workerPayroll,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a WorkerPayroll entity.
     *
     * @param WorkerPayroll $workerPayroll The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(WorkerPayroll $workerPayroll)
    {
        $form = $this->createForm(new WorkerPayrollType($this->getUser()), $workerPayroll, array(
            'action' => $this->generateUrl('workerpayroll_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new WorkerPayroll entity.
     *
     * @Route("/new", name="workerpayroll_new")
     *
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $workerPayroll = new WorkerPayroll();
        $form   = $this->createCreateForm($workerPayroll);

        return array(
            'entity' => $workerPayroll,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a WorkerPayroll entity.
     *
     * @Route("/{id}", name="workerpayroll_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $workerPayroll = $manager->getRepository('AppBundle:WorkerPayroll')->find($id);

        if (!$workerPayroll) {
            throw $this->createNotFoundException('Unable to find WorkerPayroll entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $workerPayroll,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing WorkerPayroll entity.
     *
     * @Route("/{id}/edit", name="workerpayroll_edit")
     *
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $workerPayroll = $manager->getRepository('AppBundle:WorkerPayroll')->find($id);

        if (!$workerPayroll) {
            throw $this->createNotFoundException('Unable to find WorkerPayroll entity.');
        }

        $editForm = $this->createEditForm($workerPayroll);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $workerPayroll,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a WorkerPayroll entity.
     *
     * @param WorkerPayroll $workerPayroll The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(WorkerPayroll $workerPayroll)
    {
        $form = $this->createForm(new WorkerPayrollType($this->getUser()), $workerPayroll, array(
            'action' => $this->generateUrl('workerpayroll_update', array('id' => $workerPayroll->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing WorkerPayroll entity.
     *
     * @Route("/{id}", name="workerpayroll_update")
     *
     * @Method("PUT")
     * @Template("AppBundle:WorkerPayroll:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $workerPayroll = $manager->getRepository('AppBundle:WorkerPayroll')->find($id);

        if (!$workerPayroll) {
            throw $this->createNotFoundException('Unable to find WorkerPayroll entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($workerPayroll);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $manager->flush();

            $this->addFlash('info', 'Data saved.');

            return $this->redirect($this->generateUrl('workerpayroll_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $workerPayroll,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a WorkerPayroll entity.
     *
     * @Route("/{id}", name="workerpayroll_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $workerPayroll = $manager->getRepository('AppBundle:WorkerPayroll')->find($id);

            if (!$workerPayroll) {
                throw $this->createNotFoundException('Unable to find WorkerPayroll entity.');
            }

            $manager->remove($workerPayroll);
            $manager->flush();

            $this->addFlash('info', 'Worker payroll deleted.');
        }

        return $this->redirect($this->generateUrl('workerpayroll'));
    }

    /**
     * Creates a form to delete a WorkerPayroll entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('workerpayroll_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
