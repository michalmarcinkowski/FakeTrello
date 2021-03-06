<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', 'textarea', array(
                'required' => false,
            ))
            ->add('deadline', 'date', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'required' => false,
            ))
            ->add('labels', 'entity', array(
                'class' => 'AppBundle\Entity\Label',
                'multiple' => true,
                'required' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'AppBundle\Entity\Card'
        ));
    }

    public function getName()
    {
        return 'app_card';
    }
}
