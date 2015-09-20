<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ThirdType extends AbstractType
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->user;

        $builder
            ->add('fullname')
            ->add('telephone')
            ->add('address')
            ->add('email')
            ->add('web')
            ->add('thirdType', 'entity', array(
                'required' => false,
                'class' => 'AppBundle:ThirdType',
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('tt')
                        ->join('tt.business', 'b')
                        ->join('b.users', 'u')
                        ->where('u.id = '.$user->getId());
                },
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Third',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_third';
    }
}
