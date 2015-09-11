<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ListThirdsType extends AbstractType
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
        foreach ($this->paginator as $third) {
            $builder
            ->add($third->getId().'fullname')
            ->add($third->getId().'email')
            ->add($third->getId().'thirdType', 'entity', array(
                'class' => 'AppBundle:ThirdType',
                'data' => $third->getThirdType(),
                'required' => false,
            ))
        ;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_thirdlist';
    }
}
