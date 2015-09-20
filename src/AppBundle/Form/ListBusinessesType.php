<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ListBusinessesType extends AbstractType
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
        foreach ($this->paginator as $business) {
            $builder
                ->add($business->getId().'fullname')
                ->add($business->getId().'cifnif')
                ->add($business->getId().'address')
            ;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_businesslist';
    }
}
