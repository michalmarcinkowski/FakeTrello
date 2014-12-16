<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BoardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('organization', 'entity', array(
                'class' => 'AppBundle\Entity\Organization',
                'required' => false,
            ))
            ->add('color', 'choice', array(
                'choices' => array(
                    'blue'    => 'Blue',
                    'yellow'  => 'Yellow',
                    'green'   => 'Green'
                ),
                'required' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'AppBundle\Entity\Board'
        ));
    }

    public function getName()
    {
        return 'app_board';
    }
}
