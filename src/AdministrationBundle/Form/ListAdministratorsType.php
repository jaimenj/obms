<?php

/**
 * This file is part of The OBMS project: https://github.com/obms/obms
 *
 * Copyright (c) Jaime Niñoles-Manzanera Jimeno.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdministrationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ListAdministratorsType extends AbstractType
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
        foreach ($this->paginator as $administrator) {
            $builder
            ->add($administrator->getId().'username', 'text', array(
                'required' => true,
            ))
            ->add($administrator->getId().'email', 'email', array(
                'required' => true,
            ));
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'administrationbundle_administratorlist';
    }
}
