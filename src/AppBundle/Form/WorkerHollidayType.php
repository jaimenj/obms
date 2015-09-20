<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class WorkerHollidayType extends AbstractType
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
            ->add('initdate', 'date', array(
                'label' => 'Init date'
            ))
            ->add('finishdate', 'date', array(
                'label' => 'Finish date'
            ))
            ->add('worker', 'entity', array(
                'class' => 'AppBundle:Worker',
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('w')
                        ->join('w.business', 'b')
                        ->where('b.id = '.$user->getCurrentBusiness()->getId());
                },
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\WorkerHolliday',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_workerholliday';
    }
}
