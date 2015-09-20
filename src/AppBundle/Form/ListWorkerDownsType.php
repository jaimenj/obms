<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class ListWorkerDownsType extends AbstractType
{
    private $paginator;

    private $user;

    public function __construct($paginator, $user)
    {
        $this->paginator = $paginator;
        $this->user = $user;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->user;

        foreach ($this->paginator as $workerdown) {
            $builder
                ->add($workerdown->getId().'initdate')
                ->add($workerdown->getId().'finishdate')
                ->add($workerdown->getId().'worker', 'entity', array(
                    'required' => false,
                    'class' => 'AppBundle:Worker',
                    'data' => $workerdown->getWorker(),
                    'query_builder' => function (EntityRepository $er) use ($user) {
                        return $er->createQueryBuilder('w')
                            ->join('w.business', 'b')
                            ->where('b.id = '.$user->getCurrentBusiness()->getId());
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
