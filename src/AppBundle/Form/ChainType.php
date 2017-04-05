<?php

namespace AppBundle\Form;

use AppBundle\Entity\Chain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChainType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->
        add('front', null, ['attr' => ['placeholder' => 'n teeth of front largest chainring']])->
        add('rear', null, ['attr' => ['placeholder' => 'n teeth of rear largest cog']])->
        add('stay', null, ['attr' => ['placeholder' => 'distance in inches']]);

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Chain'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_chain';
    }


}
