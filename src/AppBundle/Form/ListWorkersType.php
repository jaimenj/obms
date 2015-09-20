<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ListWorkersType extends AbstractType
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
        foreach ($this->paginator as $worker) {
            $builder
                ->add($worker->getId().'fullname')
                ->add($worker->getId().'telephone')
                ->add($worker->getId().'email', 'email')
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
