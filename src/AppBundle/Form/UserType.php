<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class UserType extends AbstractType
{
    private $user;

    public function __construct($user){
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
            ->add('currentBusiness', 'entity', array(
                'class' => 'AppBundle:Business',
                'data' => $user->getCurrentBusiness(),
                'required' => false,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('b')
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
            'data_class' => 'AdministrationBundle\Entity\User',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_user';
    }
}
