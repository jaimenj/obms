<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class ListThirdsType extends AbstractType
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

        foreach ($this->paginator as $third) {
            $builder
            ->add($third->getId().'fullname')
            ->add($third->getId().'email')
            ->add($third->getId().'thirdType', 'entity', array(
                'required' => false,
                'class' => 'AppBundle:ThirdType',
                'data' => $third->getThirdType(),
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('tt')
                        ->join('tt.business', 'b')
                        ->join('b.users', 'u')
                        ->where('u.id = '.$user->getId());
                },
            ));
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
