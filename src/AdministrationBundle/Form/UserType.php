<?php

namespace AdministrationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email', 'email')
            ->add('newpassword', 'password', array(
                'mapped' => false,
                'label' => 'New password',
                'required' => false,
            ))
            ->add('newpassword2', 'password', array(
                'mapped' => false,
                'label' => 'Repeat the new password',
                'required' => false,
            ))
            ->add('isenabled', 'checkbox', array(
                'label' => 'Is enabled.',
                'required' => false,
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdministrationBundle\Entity\User',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'administrationbundle_user';
    }
}
