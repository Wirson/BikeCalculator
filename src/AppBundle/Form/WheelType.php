<?php

namespace AppBundle\Form;

use AppBundle\Entity\Wheel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WheelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->
        add('ERD', null, ['attr' => ['placeholder' => 'ERD'], 'label' => 'Effective rim diameter in mm'])->
        add('holes', null, ['attr' => ['placeholder' => 'just count them'], 'label' => 'Number of holes'])->
        add('centerToLeft', null, ['attr' => ['placeholder' => 'mm'], 'label' => 'Distance from center of hub to left flange'])->
        add('centerToRight', null, ['attr' => ['placeholder' => 'mm'], 'label' => 'Distance from center of hub to right flange'])->
        add('flangeDiameter', null, ['attr' => ['placeholder' => 'mm'], 'label' => 'Flange diameter'])->
        add('crosses', null, ['attr' => ['placeholder' => '0-4'], 'label' => 'Number of crosses']);

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Wheel'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_wheel';
    }


}
