<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ListThirdTypesType extends AbstractType
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
        foreach ($this->paginator as $thirdType) {
            $builder->add($thirdType->getId() . 'name');
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_thirdtypelist';
    }
}
