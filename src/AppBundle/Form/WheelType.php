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
        add('ERD', null, ['attr' => ['placeholder' => 'Effective rim diameter in mm']])->
        add('holes', null, ['attr' => ['placeholder' => 'number of holes']])->
        add('centerToLeft', null, ['attr' => ['placeholder' => 'center to left distance in mm']])->
        add('centerToRight', null, ['attr' => ['placeholder' => 'center to right distance in mm']])->
        add('flangeDiameter', null, ['attr' => ['placeholder' => 'Flange Diameter in mm']])->
        add('crosses', null, ['attr' => ['placeholder' => 'number of crosses, 0-4']]);

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
