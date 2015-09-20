<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class ListWorkerDownsType extends AbstractType
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
        foreach ($this->paginator as $workerDown) {
            $builder
                ->add($workerDown->getId().'initdate', 'date', array(
                    'data' => $workerDown->getInitdate(),
                ))
                ->add($workerDown->getId().'finishdate', 'date', array(
                    'data' => $workerDown->getInitdate(),
                ))
                ->add($workerDown->getId().'worker', 'entity', array(
                    'class' => 'AppBundle:Worker',
                    'data' => $workerDown->getWorker(),
                    'query_builder' => function (EntityRepository $er) use ($workerDown) {
                        return $er->createQueryBuilder('w')
                            ->join('w.business', 'b')
                            ->where('b.id = '.$workerDown->getWorker()->getBusiness()->getId());
                    },
                ));
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_workerdownlist';
    }
}
