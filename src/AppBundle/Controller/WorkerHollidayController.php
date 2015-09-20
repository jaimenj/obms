<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\WorkerHolliday;
use AppBundle\Form\WorkerHollidayType;
use AppBundle\Form\ListWorkerHollidaysType;

/**
 * WorkerHolliday controller.
 *
 * @Route("/workerholliday")
 */
class WorkerHollidayController extends Controller
{
    /**
     * Lists all WorkerHolliday entities.
     *
     * @Route("/", name="workerholliday")
     *
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $querybuilder = $manager->createQueryBuilder()
            ->select('wh')
            ->from('AppBundle:WorkerHolliday', 'wh')
            ->join('wh.worker', 'w')
            ->join('w.business', 'b')
            ->where('b.id = '.$this->getUser()->getCurrentBusiness()->getId());

        $paginator = $this->get('knp_paginator');
        $paginator = $paginator->paginate($querybuilder->getQuery(), $this->getRequest()->query->get('page', 1), 10);

        $formListWorkerHollidays = $this->createForm(new ListWorkerHollidaysType($paginator));

        if ($request->getMethod() == 'POST') {
            $formListWorkerHollidays->handleRequest($request);
            if ($formListWorkerHollidays->isValid()) {
                foreach ($paginator as $workerHolliday) {
                    $workerHolliday->setInitdate($formListWorkerHollidays[$workerHolliday->getId().'initdate']->getData());
                    $workerHolliday->setFinishdate($formListWorkerHollidays[$workerHolliday->getId().'finishdate']->getData());
                    $workerHolliday->setWorker($formListWorkerHollidays[$workerHolliday->getId().'worker']->getData());
                    $manager->persist($workerHolliday);
                }
                $manager->flush();

                $this->addFlash('info', 'Data saved.');
            } else {
                $this->addFlash('danger', 'ERROR: '.$formListWorkerHollidays->getErrorsAsString());
            }
        }

        return array(
            'paginator' => $paginator,
            'formListWorkerHollidays' => $formListWorkerHollidays->createView(),
        );
    }

    /**
     * Creates a new WorkerHolliday entity.
     *
     * @Route("/new", name="workerholliday_create")
     *
     * @Method("POST")
     * @Template("AppBundle:WorkerHolliday:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $workerHolliday = new WorkerHolliday();
        $form = $this->createCreateForm($workerHolliday);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($workerHolliday);
            $manager->flush();

            $this->addFlash('info', 'Worker holliday created.');

            return $this->redirect($this->generateUrl('workerholliday_show', array('id' => $workerHolliday->getId())));
        }

        return array(
            'entity' => $workerHolliday,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a WorkerHolliday entity.
     *
     * @param WorkerHolliday $workerHolliday The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(WorkerHolliday $workerHolliday)
    {
        $form = $this->createForm(new WorkerHollidayType(), $workerHolliday, array(
            'action' => $this->generateUrl('workerholliday_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new WorkerHolliday entity.
     *
     * @Route("/new", name="workerholliday_new")
     *
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $workerHolliday = new WorkerHolliday();
        $form   = $this->createCreateForm($workerHolliday);

        return array(
            'entity' => $workerHolliday,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a WorkerHolliday entity.
     *
     * @Route("/{id}", name="workerholliday_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $workerHolliday = $manager->getRepository('AppBundle:WorkerHolliday')->find($id);

        if (!$workerHolliday) {
            throw $this->createNotFoundException('Unable to find WorkerHolliday entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $workerHolliday,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing WorkerHolliday entity.
     *
     * @Route("/{id}/edit", name="workerholliday_edit")
     *
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getDoctrine()->getManager();

        $workerHolliday = $manager->getRepository('AppBundle:WorkerHolliday')->find($id);

        if (!$workerHolliday) {
            throw $this->createNotFoundException('Unable to find WorkerHolliday entity.');
        }

        $editForm = $this->createEditForm($workerHolliday);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $workerHolliday,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a WorkerHolliday entity.
     *
     * @param WorkerHolliday $workerHolliday The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(WorkerHolliday $workerHolliday)
    {
        $form = $this->createForm(new WorkerHollidayType($this->getUser()), $workerHolliday, array(
            'action' => $this->generateUrl('workerholliday_update', array('id' => $workerHolliday->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing WorkerHolliday entity.
     *
     * @Route("/{id}", name="workerholliday_update")
     *
     * @Method("PUT")
     * @Template("AppBundle:WorkerHolliday:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();

        $workerHolliday = $manager->getRepository('AppBundle:WorkerHolliday')->find($id);

        if (!$workerHolliday) {
            throw $this->createNotFoundException('Unable to find WorkerHolliday entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($workerHolliday);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $manager->flush();

            $this->addFlash('info', 'Data saved.');

            return $this->redirect($this->generateUrl('workerholliday_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $workerHolliday,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a WorkerHolliday entity.
     *
     * @Route("/{id}", name="workerholliday_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $workerHolliday = $manager->getRepository('AppBundle:WorkerHolliday')->find($id);

            if (!$workerHolliday) {
                throw $this->createNotFoundException('Unable to find WorkerHolliday entity.');
            }

            $manager->remove($workerHolliday);
            $manager->flush();

            $this->addFlash('info', 'Worker holliday deleted.');
        }

        return $this->redirect($this->generateUrl('workerholliday'));
    }

    /**
     * Creates a form to delete a WorkerHolliday entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('workerholliday_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
