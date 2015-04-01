<?php

namespace Pequiven\IndicatorBundle\Form\Indicator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeatureIndicatorType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeFeatureIndicator',null,array(
                'label' => 'form.feature_indicator',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "input input-large validate[required]"
                ),
            ))
            ->add('description',null,array(
                'label' => 'form.description_feature_indicator',
                'label_attr' => array('class' => 'label'),
                'attr' => array(
                    'class' => "validate[required]",
                    "rows" => "10",
                    "style" => "margin: 0px; width: 433px; height: 175px;",
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pequiven\IndicatorBundle\Entity\Indicator\FeatureIndicator',
            'translation_domain' => 'PequivenIndicatorBundle',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pequiven_indicatorbundle_indicator_featureindicator';
    }
}
