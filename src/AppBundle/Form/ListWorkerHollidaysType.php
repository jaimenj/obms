<?php

/**
 * This file is part of The OBMS project: https://github.com/obms/obms
 *
 * Copyright (c) Jaime Niñoles-Manzanera Jimeno.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class ListWorkerHollidaysType extends AbstractType
{
    private $paginator;

    public function __construct($paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->paginator as $workerHolliday) {
            $builder
                ->add($workerHolliday->getId().'initdate', 'date', array(
                    'data' => $workerHolliday->getInitdate(),
                ))
                ->add($workerHolliday->getId().'finishdate', 'date', array(
                    'data' => $workerHolliday->getInitdate(),
                ))
                ->add($workerHolliday->getId().'worker', 'entity', array(
                    'class' => 'AppBundle:Worker',
                    'data' => $workerHolliday->getWorker(),
                    'query_builder' => function (EntityRepository $er) use ($workerHolliday) {
                        return $er->createQueryBuilder('w')
                            ->join('w.business', 'b')
                            ->where('b.id = '.$workerHolliday->getWorker()->getBusiness()->getId());
                    }
                ))
            ;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_workerlist';
    }
}
