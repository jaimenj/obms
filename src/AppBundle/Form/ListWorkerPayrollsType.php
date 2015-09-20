<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class ListWorkerPayrollsType extends AbstractType
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
        foreach ($this->paginator as $workerPayroll) {
            $builder
                ->add($workerPayroll->getId().'year', 'integer', array(
                    'attr' => array('min' => 2000, 'max' => 2050),
                ))
                ->add($workerPayroll->getId().'month', 'integer', array(
                    'attr' => array('min' => 1, 'max' => 12),
                ))
                ->add($workerPayroll->getId().'amount', 'money')
                ->add($workerPayroll->getId().'worker', 'entity', array(
                    'class' => 'AppBundle:Worker',
                    'data' => $workerPayroll->getWorker(),
                    'query_builder' => function (EntityRepository $er) use ($workerPayroll) {
                        return $er->createQueryBuilder('w')
                            ->join('w.business', 'b')
                            ->where('b.id = '.$workerPayroll->getWorker()->getBusiness()->getId());
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
